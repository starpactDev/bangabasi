<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\NewsletterUser;
use App\Http\Controllers\Controller;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        try {
            // Validate the form input
            $request->validate([
                'email' => 'required|email|unique:newsletter_users,email',
            ]);

            // Store the email in the session for later use
            session(['email' => $request->email]);

            // Create the new newsletter user (email only for now)
            NewsletterUser::create([
                'email' => $request->email,
                'is_subscribed' => true,
            ]);

            // Return a JSON response indicating success
            return response()->json([
                'status' => 'success',
                'message' => 'Almost done! Enter your name to complete the subscription.',
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Concatenate all validation errors into a single string
            $errorMessage = implode(' ', collect($e->errors())->flatten()->all());
        
            // Return a JSON response with the concatenated validation error messages
            return response()->json([
                'status' => 'error',
                'message' => $errorMessage,
            ], 422); // 422 is the HTTP status code for Unprocessable Entity
        }
    }
    

    public function completeSubscription(Request $request)
    {
        // Retrieve the email from the session
        $email = session('email');

        // Check if email exists in session
        if (!$email) {
            return response()->json(['status' => 'error', 'message' => 'Email session expired. Please start over.']);
        }

        // Validate the name input
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ]);

        // Update the newsletter user with the first and last name
        $user = NewsletterUser::where('email', $email)->first();
        if ($user) {
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->save();
        }

        // Clear the email session after the second submission
        session()->forget('email');

        return response()->json(['status' => 'success', 'message' => 'Subscription completed successfully!']);
    }
}