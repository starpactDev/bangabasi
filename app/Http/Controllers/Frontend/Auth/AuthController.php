<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
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

    public function loginTry( Request $request )
    {
        $request->validate([
           "email" => "required|email",
           "password" => "required|min:6"
        ]);

        $user = Auth::attempt($request->only('email', 'password'));
        

        if($user){
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


    public function logout1( Request $request )
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
}
