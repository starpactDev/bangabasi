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
        .newsletter-message {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 0 1rem rgba(0, 0, 0, 0.05);
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
        Bangabasi.com – Latest Newsletter
    </div>
    
    <div class="content">
        <p>Dear Subscriber,</p>
        
        <p>We hope this message finds you well! We are excited to share the latest news and updates with you.</p>
        
        <p><strong>{{ $subject }}</strong></p>

        <div class="newsletter-message">
            <p>{{ $messageContent }}</p>
        </div>

        <p>If you have any questions or would like more information, feel free to contact us through our <a href="{{ url('/contact-us') }}">Contact Page</a>.</p>
        
        <p>Best regards,</p>
        <p><strong>Bangabasi Team</strong></p>
    </div>

    <div class="footer">
        <p>Stay connected with us!</p>
        <p><a href="https://bangabasi.com">Visit our Website</a> | Mail Us: <a href="mailto:{{ env('MAIL_FROM_ADDRESS') }}">{{ env('MAIL_FROM_ADDRESS') }}</a></p>
        <p>If you no longer wish to receive emails from us, you can <a href="{{ $unsubscribeLink }}">unsubscribe here</a>.</p>
    </div>
</div>

</body>
</html>
