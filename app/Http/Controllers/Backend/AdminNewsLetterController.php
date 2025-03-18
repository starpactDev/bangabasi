<?php

namespace App\Http\Controllers\Backend;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use App\Services\MailService;
use App\Models\NewsletterUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminNewsLetterController extends Controller
{
    public function index()
    {
        $newsletterUsers = NewsletterUser::orderBy('created_at', 'desc')->paginate(4);

        $newsLetters = Newsletter::orderBy('created_at', 'desc')->paginate(4);

        return view('admin.pages.newsletter.index', compact('newsletterUsers', 'newsLetters'));
    }


    public function sendNewsletter(Request $request, MailService $mailService)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'users' => 'required|array|min:1',
            'users.*' => [
                'exists:newsletter_users,id',
                function ($attribute, $value, $fail) {
                    $user = NewsletterUser::find($value);
                    if (!$user->is_subscribed) {
                        $fail('The selected user '.$user->email.' is not subscribed.');
                    }
                }
            ],
        ]);
    
        $selectedUsers = NewsletterUser::whereIn('id', $request->users)->get();
        $subject = $request->subject;
        $messageContent = $request->message;
    
        // Extract emails from selected users
        $emails = $selectedUsers->pluck('email')->toArray();

        // Create a new newsletter record in the database
        $newsletter = Newsletter::firstOrCreate(
            ['subject' => $subject, 'status' => 'queued'],
            [
                'content' => $messageContent,
                'from_email' => env('MAIL_FROM_ADDRESS'),
                'from_name' => env('MAIL_FROM_NAME'),
                'type' => 'regular', // Default type (can be modified based on your use case)
                'recipient_count' => count($emails),
                'sent_email_ids' => json_encode([]), // Empty array initially
                'unsubscribe_link' => '', // Placeholder link
            ]
        );
    
        // Track success and failure counts
        $successCount = 0;
        $failureCount = 0;

        // Send the newsletter email to selected users
        foreach ($emails as $email) {
            try {
                // Generate a unique unsubscribe link for each user
                $unsubscribe_link = route('newsletter.unsubscribe', ['token' => base64_encode($email . env('UNSUBSCRIBE_SALT'))]);
                // Send the email
                $mailService->sendNewsletterEmail([$email], $subject, $messageContent, $unsubscribe_link);

                // Increment success count if the email is sent successfully
                $successCount++;
            } catch (\Swift_TransportException $e) {
                // This exception is thrown when there's a transport issue (e.g., invalid email address)
                session()->flash('error', 'Transport issue for ' . $email . ': ' . $e->getMessage());
                $failureCount++;
            } catch (\Swift_RfcComplianceException $e) {
                // This exception is thrown for invalid email addresses (e.g., malformed emails)
                session()->flash('error', 'Invalid email address for ' . $email . ': ' . $e->getMessage());
                $failureCount++;
            } catch (\Swift_AuthenticationException $e) {
                // This exception handles issues like wrong SMTP credentials (authentication error)
                session()->flash('error', 'Authentication error for ' . $email . ': ' . $e->getMessage());
                $failureCount++;
            } catch (\Swift_SwiftException $e) {
                // This catches other SwiftMailer errors, including connection or rate-limiting errors
                session()->flash('error', 'SwiftMailer error for ' . $email . ': ' . $e->getMessage());
                $failureCount++;
            } catch (\Exception $e) {
                // Generic exception handler for any unexpected error
                session()->flash('error', 'Unexpected error for ' . $email . ': ' . $e->getMessage());
                $failureCount++;
            }
        }

        // Increment the counts and append sent email IDs
        $newsletter->increment('success_count', $successCount);
        $newsletter->increment('failure_count', $failureCount);

        // Append the sent email IDs incrementally
        $sentEmails = json_decode($newsletter->sent_email_ids, true);
        $sentEmails = array_merge($sentEmails, $emails);

        // Update the newsletter record with success and failure counts, and sent status
        $newsletter->update([
            'sent_email_ids' => json_encode($emails), // Store sent email IDs
        ]);

        $availble_users = NewsletterUser::where('is_subscribed', true)->get();

        // After all pages are processed, update the status
        if ($newsletter->recipient_count == count($availble_users)) {
            $newsletter->update([
                'status' => $failureCount > 0 ? 'failed' : 'sent',
                'sent_at' => now(), // Mark the timestamp when the email was sent
            ]);
        }
    
        // Redirect to the next page in the pagination
        $nextPage = $request->has('page') ? $request->input('page') + 1 : 2;
        return redirect()->route('admin.newsletter', ['page' => $nextPage])
                        ->with('success', "Newsletter sent successfully to ". count($sentEmails)." of " . count($availble_users) . " recipients.")
                        ->withInput();
    }

    public function unsubscribe(Request $request, $token)
    {
        // Check if the token exists and is a valid string
        if (empty($token) || !is_string($token)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid token'
            ], 400); // 400 Bad Request
        }

        // Decode the token to get the email and salt
        $decoded = base64_decode($token);
        $salt = env('UNSUBSCRIBE_SALT'); // Get salt from the .env
        
        // Extract the email from the decoded string
        $email = str_replace($salt, '', $decoded);
        
        // Check if the email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email address'
            ], 400); // 400 Bad Request
        }
        
        // Check if the user exists and proceed with unsubscription
        $user = NewsletterUser::where('email', $email)->first();
        
        if ($user) {
            // Mark the user as unsubscribed
            $user->is_subscribed = false;
            $user->save();
            
            // Return a success JSON response
            return response()->json([
                'status' => 'success',
                'message' => 'You have successfully unsubscribed.'
            ], 200); // 200 OK
        } else {
            // User not found, show an error message
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404); // 404 Not Found
        }
    }


    
    


}
