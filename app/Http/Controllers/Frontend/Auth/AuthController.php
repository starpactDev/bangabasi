<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //

    public function login()
    {
        if (request()->has('redirect')) {
            session(['url.intended' => request()->redirect]);

            if (request()->has('product_id')) {
                session(['product_id' => request()->product_id]);
            }
        }
        return view('authentication');
    }

    public function loginTry(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required|min:6"
        ]);

        $user = Auth::attempt($request->only('email', 'password'));


        if ($user) {
            $redirectUrl = session()->pull('url.intended', route('myprofile'));
            $productId = session()->pull('product_id', null);

            //dd($redirectUrl, $productId);

            // If we have both URL and product_id, keep the product_id in the response
            if ($productId) {
                return response()->json([
                    "message" => "success",
                    "redirect_url" => $redirectUrl,
                    "product_id" => $productId
                ]);
            }

            return response()->json([
                "message" => "success",
                "redirect_url" => $redirectUrl
            ]);
        }

        return response()->json(["message" => " Please enter valid credentials "], 401);
    }


    public function logout1(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function register(Request $request)
    {
        try {
            // Validate request
            $validatedData = $request->validate([
                "firstname" => "required|string|max:255",
                "lastname" => "required|string|max:255",
                "email" => "required|email|unique:users,email",
                "phone_number" => "required|digits:10|unique:users,phone_number",
                "password" => "required|min:6|confirmed",
                "terms" => "accepted",
                "g-recaptcha-response" => "required",
            ]);

            // Verify reCAPTCHA
            $recaptchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ])->json();

            if (!$recaptchaResponse['success'] || $recaptchaResponse['score'] < 0.5) {
                return response()->json(["errors" => ["recaptcha" => ["reCAPTCHA verification failed."]]], 422);
            }

            // Create user
            $validatedData['password'] = Hash::make($request->password);
            $validatedData["usertype"] = "user";
            $user = User::create($validatedData);

            if ($user && Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json(["message" => "success"]);
            }

            return response()->json(["message" => "Authentication failed"], 401);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(["errors" => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(["message" => "Something went wrong", "error" => $e->getMessage()], 500);
        }
    }

    public function sendOTP(Request $request)
    {
        // Validate the email address
        $request->validate([
            'email' => 'required|email',
        ]);

        // Check if the email exists in the database
        $user = User::where('email', $request->email)->first();

        // If the email doesn't exist, return a response indicating it's not registered
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'This email is not registered.',
            ], 404); // 404 Not Found
        }

        // Generate a random OTP
        $otp = rand(100000, 999999); // or use a more secure method to generate the OTP

        // Send OTP via email (assuming you have a Mail class for this)
        try {
            // You can implement your OTP email logic here (e.g., using Mail::to($user->email)->send(new OtpMail($otp))); 

            // Save the OTP in the session
            session([
                'otp' => $otp,
                'email' => $request->email, // Save the email for password reset
                'otp_expiry' => now()->addMinutes(10), // Set OTP expiry (e.g., 10 minutes)
            ]);

            // Return success response
            return response()->json([
                'success' => true,
                'otp' => $otp, // Send OTP in response for testing (optional, can be removed)
                'email' => $request->email,
                'message' => 'OTP sent successfully.',
            ], 200); // 200 OK

        } catch (\Exception $e) {
            // Return failure response in case of an error (e.g., email send failure)
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP. Please try again.',
            ], 500); // 500 Internal Server Error
        }
    }

    public function verifyOTP(Request $request)
    {
        // Validate the OTP input
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        // Retrieve the OTP and expiry time from the session
        $sessionOtp = session('otp');
        $otpExpiry = session('otp_expiry');

        // Check if the OTP exists in the session
        if (!$sessionOtp || !$otpExpiry) {
            return response()->json([
                'success' => false,
                'message' => 'OTP has expired or not found.',
            ], 400); // 400 Bad Request
        }

        // Check if the OTP has expired
        if (now()->greaterThan($otpExpiry)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP has expired.',
            ], 400); // 400 Bad Request
        }

        // Check if the provided OTP matches the session OTP
        if ($request->otp == $sessionOtp) {
            


            // OTP is valid
            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully.',
            ], 200); // 200 OK
        } else {
            // OTP is invalid
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP.',
            ], 400); // 400 Bad Request
        }
    }

    public function setNewPassword(Request $request)
    {

        try {
            // Validate the input
            $request->validate([
                'new-password' => 'required|min:6|confirmed',
            ]);

            // Retrieve the OTP from the session
            $otp = session('otp');
            $otpExpiry = session('otp_expiry');

            if (!$otp || now()->greaterThan($otpExpiry)) {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP has expired. Please request a new one.',
                ], 422);
            }

            // Retrieve user from session (assuming email was stored during OTP verification)
            $email = session('email');

            if (!$email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please try again.',
                ], 422);
            }

            $user = User::where('email', $email)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.',
                ], 404);
            }

            // Update user's password
            $user->password = Hash::make($request->input('new-password'));
            $user->save();

            // Clear OTP session data
            session()->forget(['otp', 'otp_expiry', 'email']);

            return response()->json([
                'success' => true,
                'message' => 'Password reset successfully.',
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(["errors" => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
