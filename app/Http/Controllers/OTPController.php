<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class OTPController extends Controller
{
    public function sendOTP(Request $request)
    {
        // Validate the request to make sure the phone number is passed
        $validated = $request->validate([
            'mobile' => 'required|numeric|min:10', // Assuming the mobile number is required and numeric
        ]);
        // Prepend the country code (91) to the mobile number
        $mobile = '91' . ltrim($request->mobile, '0'); // Remove leading 0 if present

        // Load .env file variables if not already done
        $authkey = env('MSG91_API_KEY');       // API key
        $sender = env('MSG91_SENDER_ID');       // Sender ID
        $templateId = env('MSG91_TEMPLATE_ID'); // Optional: Template ID
        $otpLength = env('MSG91_OTP_LENGTH', 6); // Default to 6 digits if not set in .env
        $expiry = env('MSG91_OTP_EXPIRY', 5);   // Default to 5 minutes expiry if not set in .env

        // Recipient's phone number from the request
        $mobile = $request->mobile;

        // Initialize the Guzzle client
        $client = new Client();

        try {
            // Sending OTP request to MSG91 API
            $response = $client->post('https://api.msg91.com/api/v5/otp', [
                'json' => [
                    'authkey' => $authkey,       // MSG91 API Key
                    'mobile' => $mobile,         // Mobile number from the request
                    'template_id' => $templateId, // Optional: Custom template ID
                    'otp_length' => $otpLength,  // OTP length
                    'expiry' => $expiry,         // OTP expiry time in minutes
                    'sender' => $sender          // Sender ID
                ]
            ]);

            // Get the response body and return a success message
            $responseData = json_decode($response->getBody(), true);
            
            // Optionally, log the response for debugging
            Log::info('MSG91 OTP Response:', $responseData);

            return response()->json([
                'status' => 'success',
                'message' => 'OTP sent successfully.',
                'response' => $responseData
            ]);
        } catch (\Exception $e) {
            // Handle any errors and return a failure message
            Log::error('Error sending OTP:', ['error' => $e->getMessage()]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send OTP.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
