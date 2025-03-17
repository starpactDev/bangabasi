<!DOCTYPE html>
<html>
<head>
    <title>{{ $subject }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #ff6f00;
            color: #ffffff;
            text-align: center;
            padding: 15px;
            border-radius: 8px 8px 0 0;
            font-size: 20px;
            font-weight: bold;
        }
        .content {
            padding: 20px;
            font-size: 16px;
            color: #333333;
        }
        .content blockquote {
            background: #f8f9fa;
            border-left: 5px solid #ff6f00;
            margin: 10px 0;
            padding: 10px;
            font-style: italic;
            color: #555555;
        }
        .footer {
            text-align: center;
            padding: 15px;
            background-color: #f8f9fa;
            font-size: 14px;
            color: #666666;
            border-radius: 0 0 8px 8px;
        }
        .footer a {
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
        <p>Dear {{ explode(' ', $userName)[0] }},</p>
        
        <p>Thank you for reaching out to us! We appreciate your patience while we reviewed your query.</p>
        
        <p>Here is our response:</p>
        <blockquote>
            {{ $replyMessage }}
        </blockquote>

        <div style="background-color: #e0e0e0; color: #5e5e5e; padding : 1rem; border-radius : 0.5rem;">
            <p>Original Query:</p>
            <blockquote>
                {{ $userQuery }}
            </blockquote>
        </div>
        
        <p>If you have any further questions, feel free to reply to this email or contact us through our <a href="{{ url('/contact-us') }}" style="color: #ff6f00;">Contact Page</a>.</p>
        
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
