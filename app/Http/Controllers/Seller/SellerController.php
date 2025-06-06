<?php

namespace App\Http\Controllers\Seller;

use App\Models\Bank;
use App\Models\User;
use App\Models\Seller;
use App\Models\GstDetail;
use App\Services\OtpService;
use Illuminate\Http\Request;
use App\Models\PickupAddress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class SellerController extends Controller
{
    public function loginSeller(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'phone_number' => 'required|digits:10',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user with the phone number and password
        $user = Auth::attempt([
            'phone_number' => $validatedData['phone_number'],
            'password' => $validatedData['password'],
        ]);

        // Check if authentication failed
        if (!$user) {
            return back()->withErrors([
                'login_error' => 'Invalid phone number or password.',
            ])->withInput();
        }

        // Check if the authenticated user is a seller
        if (Auth::user()->usertype !== 'seller') {
            return back()->withErrors([
                'login_error' => 'You are not authorized as a seller.',
            ])->withInput();
        }

        // Regenerate the session to prevent session fixation attacks
        $request->session()->regenerate();

        // Redirect to dashboard or next step
        return redirect()->intended(route('seller_dashboard'))->with('success', 'Welcome back!');
    }

    public function processPhoneNumber(Request $request,  OtpService $otpService)
    {
        $request->validate([
            'phone' => 'required|digits:10',
        ]);

        
        $mobile = $request->phone;
        $otp = rand(1000, 9999); 

        $params = [
            'otp' => $otp,
        ];

        $response = $otpService->sendOtp($mobile, $params);
        //$response = 'OTP sent successfully!'; // Placeholder for actual response

        // Store phone number, OTP status, and timestamp in the session
        session([
            'phone_number' => $request->phone,
            'otp_sent' => true,
            'otp_timestamp' => now() // Storing current timestamp
        ]);

        Cache::put('otp_' . $mobile, $otp, now()->addMinutes(5));

        // Redirect to the registration page
        return redirect()->route('seller_registration');
    }

    public function sendOtp(Request $request, OtpService $otpService)
    {
        $request->validate([
            'phone_number' => 'required|digits:10',
        ]);

        $mobile = $request->phone_number;
        $otp = rand(1000, 9999); 

        $params = [
            'otp' => $otp,
        ];

        $response = $otpService->sendOtp($mobile, $params);
        //$response = 'OTP sent successfully!'; // Placeholder for actual response

        Cache::put('otp_' . $mobile, $otp, now()->addMinutes(5));
        
        return response()->json([
            'status' => 'success',
            'message' => $response,
        ]);

    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|digits:10',
            'otp' => 'required|digits:4',
        ]);

        $mobile = $request->phone_number;
        $userInputOtp = $request->otp;

        $cachedOtp = Cache::get('otp_' . $mobile);

        if (!$cachedOtp) {
            return response()->json([
                'status' => 'error',
                'message' => 'OTP expired or not found.',
            ], 422);
        }

        if ($cachedOtp != $userInputOtp) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid OTP.',
            ], 401);
        }

        // OTP is correct, you can now authenticate or mark as verified
        Cache::forget('otp_' . $mobile); // Clear OTP

        session(['otp_verified' => [
            'phone_number' => $mobile,
            'verified' => true,
        ]]);

        return response()->json([
            'status' => 'success',
            'message' => 'OTP verified successfully.',
        ]);
    }



    public function register(Request $request)
    {
        // Validate phone number, OTP, and password
        $validatedData = $request->validate([
            'phone_number' => 'required|digits:10|unique:users,phone_number',
            'email' => 'required|email|unique:users,email',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password', // Confirm password validation
        ]);

        $verifiedSession = session('otp_verified');

        if (
            !$verifiedSession ||
            $verifiedSession['phone_number'] !== $validatedData['phone_number'] ||
            !$verifiedSession['verified']
        ) {
            return back()->withErrors(['otp' => 'Phone number not verified via OTP.']);
        }


        $imageName = 'bangabasi_logo_short.png';
        // Handle logo upload
        if ($request->hasFile('image')) {
            // Get the file extension
            $extension = $request->file('image')->getClientOriginalExtension();

            // Generate a unique name using timestamp and random number
            $imageName = time() . '_' . rand(1000, 9999) . '.' . $extension;

            // Move the file to the 'public/user/uploads/profile' directory
            $request->file('image')->move(public_path('user/uploads/profile'), $imageName);
        }



        // Store user in the database
        $user = User::create([
            'firstname' => 'First',
            'lastname' => 'Last',
            'email' => $validatedData['email'],
            'image' => $imageName,
            'usertype' => 'seller',
            'phone_number' => $validatedData['phone_number'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Create a seller record associated with the user
        Seller::create([
            'user_id' => $user->id,
            'registration_step' => 1, // Set registration step to 1
            'is_active' => 0,         // Set is_active to 0 (inactive)
        ]);

        // Store user ID in the session
        session(['user_id' => $user->id]);
        // Log the user in
        Auth::login($user);
        session()->forget(['otp_sent', 'phone_number', 'otp_verified']);

        // Redirect with success message
        return redirect()->route('seller_gstverification')->with('success', 'Registration successful!');
    }

    public function gstverification(Request $request)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            abort(403, 'You must be authorised to access.');
        }

        $user = Auth::user();

        // Ensure the user has the 'seller' usertype
        if ($user->usertype !== 'seller') {
            abort(403, 'Unauthorized action.');
        }

        return view('seller.gstverification', compact('user'));
    }

    public function submitGstDetails(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'You must be logged in to submit GST details.');
        }

        $user = Auth::user();

        $validatedData = $request->validate([
            'verification_type' => 'required|in:gst,uain',
            'gst_number' => 'nullable|required_if:verification_type,gst|string|size:15|unique:gst_details,gst_number',
            'business_name' => 'nullable|required_if:verification_type,gst|string|max:255',
            'legal_name' => 'nullable|required_if:verification_type,gst|string|max:100',
            'business_type' => 'nullable|required_if:verification_type,gst|string|max:100',
            'address' => 'nullable|required_if:verification_type,gst|string',
            'uain' => 'nullable|required_if:verification_type,uain|string|max:20'
        ]);

        if ($validatedData['verification_type'] === 'gst') {
            GstDetail::create([
                'user_id' => $user->id,
                'gst_number' => $validatedData['gst_number'],
                'business_name' => $validatedData['business_name'],
                'legal_name' => $validatedData['legal_name'],
                'business_type' => $validatedData['business_type'],
                'address' => $validatedData['address'],
            ]);
        } else {
            GstDetail::create([
                'user_id' => $user->id,
                'uin' => $validatedData['uain'],
            ]);
        }

        Seller::updateOrCreate(
            ['user_id' => $user->id],
            ['registration_step' => 2]
        );

        return redirect()->route('seller_pickupverification')->with('success', 'Details submitted successfully. Our team will verify and notify you shortly.');
    }

    public function showPickupVerification()
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            abort(403, 'You must be logged in to access this page.');
        }

        $user = Auth::user();

        // Ensure the user is a seller
        if ($user->usertype !== 'seller') {
            abort(403, 'Only sellers can access this page.');
        }

        // Ensure the user has completed GST verification
        $gstDetail = GstDetail::where('user_id', $user->id)->first();
        if (!$gstDetail) {
            return redirect()->route('seller_gstverification')->withErrors(['error' => 'Please complete GST verification first.']);
        }

        // Render the pickup verification page
        return view('seller.pickupverification');
    }
    public function submitPickupAddress(Request $request)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            abort(403, 'You must be logged in to submit pickup address.');
        }

        $user = Auth::user();
        // Validate the form inputs
        $validatedData = $request->validate([
            'building' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'locality' => 'required|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'pincode' => 'required|string|size:6',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
        ]);

        // Check if a pickup address already exists for this user
        if (PickupAddress::where('user_id', $user->id)->exists()) {
            return back()->withErrors(['error' => 'Pickup address already submitted.']);
        }

        // Save the pickup address
        PickupAddress::create([
            'user_id' => $user->id,
            'building' => $validatedData['building'],
            'street' => $validatedData['street'],
            'locality' => $validatedData['locality'],
            'landmark' => $validatedData['landmark'],
            'pincode' => $validatedData['pincode'],
            'city' => $validatedData['city'],
            'state' => $validatedData['state'],
        ]);

        // Create or update the Seller record
        $seller = Seller::updateOrCreate(
            ['user_id' => $user->id], 
            [
                'registration_step' => 3  // Set registration step to 3 after pickup address submission
            ]
        );

        return redirect()->route('seller_bankverification')->with('success', 'Pickup address submitted successfully!');
    }

    public function showBankVerificationPage()
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            abort(403, 'You must be logged in to access this page.');
        }

        $user = Auth::user();

        // Check if the user is a valid seller
        if ($user->usertype !== 'seller') {
            abort(403, 'Only sellers can access this page.');
        }

        // Check if GST details are submitted
        $gstDetails = GstDetail::where('user_id', $user->id)->first();
        if (!$gstDetails) {
            return redirect()->route('seller_gstverification')->withErrors(['error' => 'Please complete GST verification before proceeding.']);
        }

        // Check if pickup address details are submitted
        $pickupAddress = PickupAddress::where('user_id', $user->id)->first();
        if (!$pickupAddress) {
            return redirect()->route('seller_pickupverification')->withErrors(['error' => 'Please complete Pickup Address verification before proceeding.']);
        }

        // Render the bank verification page
        return view('seller.bankverification');
    }

    public function submitBankDetails(Request $request)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            abort(403, 'You must be logged in to submit bank details.');
        }

        $user = Auth::user();

        // Validate the bank details
        $validatedData = $request->validate([
            'bank_name' => 'required|string|max:255',
            'branch_name' => 'required|string|max:255',
            'ifsc_code' => 'required|string|size:11',
            'account_number' => 'required|numeric|digits_between:9,18',
            'confirm_account_number' => 'required|same:account_number',
            'account_holder_name' => 'required|string|max:255',
            //    'account_type' => 'required|in:savings,current',
            'terms' => 'accepted',
        ]);

        // Check if the user has already submitted bank details
        if (Bank::where('user_id', $user->id)->exists()) {
            return back()->withErrors(['error' => 'Bank details already submitted.']);
        }

        // Save the bank details
        Bank::create([
            'user_id' => $user->id,
            'bank_name' => $validatedData['bank_name'],
            'branch_name' => $validatedData['branch_name'],
            'ifsc_code' => $validatedData['ifsc_code'],
            'account_number' => $validatedData['account_number'],
            'account_holder_name' => $validatedData['account_holder_name'],
            //    'account_type' => $validatedData['account_type'],
        ]);

        // Create or update the Seller record
        $seller = Seller::updateOrCreate(
            ['user_id' => $user->id], 
            [
                'registration_step' => 4  // Set registration step to 4 after bank details submission
            ]            
            );
        return redirect()->route('seller_sellerverification')->with('success', 'Bank details submitted successfully!');
    }

    public function sellerVerification()
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            abort(403, 'You must be logged in to access this page.');
        }

        $user = Auth::user();

        // Check if the user has completed all steps: GST, Pickup, and Bank Details
        $gstDetails = GstDetail::where('user_id', $user->id)->exists();
        $pickupDetails = PickupAddress::where('user_id', $user->id)->exists();
        $bankDetails = Bank::where('user_id', $user->id)->exists();

        // If any of the details are missing, redirect to the respective step
        if (!$gstDetails) {
            return redirect()->route('seller_gstverification')->withErrors(['error' => 'Please complete the GST details before proceeding.']);
        }

        if (!$pickupDetails) {
            return redirect()->route('seller_pickupverification')->withErrors(['error' => 'Please complete the Pickup details before proceeding.']);
        }

        if (!$bankDetails) {
            return redirect()->route('seller_bankverification')->withErrors(['error' => 'Please complete the Bank details before proceeding.']);
        }

        // All steps completed, return the final verification page
        return view('seller.sellerverification');
    }

    public function storeSellerDetails(Request $request)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            abort(403, 'You must be logged in to submit bank details.');
        }

        $user = Auth::user();

        $request->validate([
            'store_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact_number' => 'required|digits:10',
            'email' => 'required|email|unique:sellers,email',
            'description' => 'required|string|max:500',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'terms' => 'accepted',
        ]);

        // Update User details
        $user = auth()->user();
        $user->firstname = $request->first_name;
        $user->lastname = $request->last_name;
        $user->contact_number = $request->contact_number;
        $user->save();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Get the file extension
            $extension = $request->file('logo')->getClientOriginalExtension();
        
            // Generate a unique name using timestamp and random number
            $logoName = time() . '_' . rand(1000, 9999) . '.' . $extension;
        
            // Move the file to the 'public/logos' directory
            $request->file('logo')->move(public_path('user/uploads/seller/logo'), $logoName);
        }


        // Create Seller entry
        Seller::updateOrCreate(
            ['user_id' => $user->id], // Condition to find the existing record
            [
                'store_name' => $request->store_name,
                'email' => $request->email,
                'description' => $request->description,
                'logo' => $logoName,
                'registration_step' => 5, // Set registration step to 5
            ]
        );

        return redirect()->route('seller_success')->with('success', 'Seller details submitted successfully!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flash('logout_message', 'You have been logged out successfully.');
        return redirect()->route('seller_login');
    }
}
