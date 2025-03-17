<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .container {
            width: 80%;
            max-width: 720px;
            margin: 2rem auto;
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0 1rem rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #ff6f00;
            color: #ffffff;
            text-align: center;
            padding: 1.5rem;
            border-radius: 1rem 1rem 0 0;
            font-size: 1.25rem;
            font-weight: bold;
        }
        .content {
            padding: 1.5rem;
            font-size: 1rem;
            color: #333333;
        }
        .content p {
            margin-bottom: 1.5rem;
        }
        .content blockquote {
            background: #f8f9fa;
            border-left: 0.3rem solid #ff6f00;
            padding: 1rem;
            margin: 1rem 0;
            font-style: italic;
            color: #555555;
            font-size: 1.1rem;
        }
        .response-wrapper {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        .reply-message, .user-query {
            background-color: #f8f9fa;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 0 1rem rgba(0, 0, 0, 0.05);
        }
        .reply-message {
            border-left: 0.3rem solid #ff6f00;
        }
        .user-query {
            margin: 1rem 0;
            background-color: #e0e0e0;
            border-left: 0.3rem solid #5e5e5e;
        }
        .footer {
            text-align: center;
            padding: 1.5rem;
            background-color: #f8f9fa;
            font-size: 1rem;
            color: #666666;
            border-radius: 0 0 1rem 1rem;
        }
        .footer a {
            color: #ff6f00;
            text-decoration: none;
        }
        a {
            color: #ff6f00;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        Bangabasi.com – Customer Support
    </div>
    
    <div class="content">
        <p>Dear {{ explode(' ', $username)[0] }},</p>
        
        <p>Thank you for reaching out to us! We appreciate your patience while we reviewed your query.</p>
        
        <p>Here is our response:</p>
        
        <div class="response-wrapper">
            <div class="reply-message">
                <h3 style="margin-top: 0;">Our Response:</h3>
                <blockquote>
                    {{ $replyMessage }}
                </blockquote>
            </div>

            <div class="user-query">
                <h3 style="margin-top: 0;">Original Query:</h3>
                <blockquote>
                    {{ $userQuery }}
                </blockquote>
            </div>
        </div>
        
        <p>If you have any further questions, feel free to reply to this email or contact us through our <a href="{{ url('/contact-us') }}">Contact Page</a>.</p>
        
        <p>Best regards,</p>
        <p><strong>Bangabasi Team</strong></p>
    </div>

    <div class="footer">
        <p>Stay connected with us!</p>
        <p><a href="https://bangabasi.com">Visit our Website</a> | Mail Us: <a href="mailto:{{ env('MAIL_FROM_ADDRESS') }}">{{ env('MAIL_FROM_ADDRESS') }}</a></p>
    </div>
</div>

</body>
</html>
