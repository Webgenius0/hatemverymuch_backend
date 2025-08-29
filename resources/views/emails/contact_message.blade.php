<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #2d3748;
            line-height: 1.6;
            padding: 30px 10px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .email-container {
            max-width: 650px;
            width: 100%;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-left: 6px solid #6366f1;
            border-right: 6px solid #6366f1;
        }

        .header {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }

        .header p {
            font-size: 16px;
            opacity: 0.9;
        }

        .content {
            padding: 30px;
        }

        .info-group {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e2e8f0;
        }

        .label {
            font-weight: 600;
            color: #4a5568;
            display: block;
            margin-bottom: 6px;
            font-size: 16px;
        }

        .highlight {
            background-color: #f0f4ff;
            padding: 12px 16px;
            border-radius: 8px;
            display: block;
            font-size: 17px;
            color: #4c51bf;
            border-left: 4px solid #6366f1;
            margin-top: 5px;
        }

        .message-container {
            margin-top: 25px;
        }

        .message-label {
            font-weight: 600;
            color: #4a5568;
            font-size: 18px;
            margin-bottom: 10px;
            display: block;
        }

        .message-content {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            color: #2d3748;
            line-height: 1.7;
            font-size: 16px;
        }

        .footer {
            text-align: center;
            padding: 25px;
            background-color: #f1f5f9;
            color: #64748b;
            font-size: 14px;
        }

        @media (max-width: 650px) {
            .email-container {
                border-left: 4px solid #6366f1;
                border-right: 4px solid #6366f1;
            }

            .header {
                padding: 20px;
            }

            .content {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>New Contact Form Submission</h1>
            <p>You've received a new message from your website</p>
        </div>

        <div class="content">
            <div class="info-group">
                <span class="label">First Name:</span>
                <span class="highlight">{{ $contact->first_name }}</span>
            </div>

            <div class="info-group">
                <span class="label">Last Name:</span>
                <span class="highlight">{{ $contact->last_name }}</span>
            </div>

            <div class="info-group">
                <span class="label">Email:</span>
                <span class="highlight">{{ $contact->email }}</span>
            </div>

            <div class="info-group">
                <span class="label">Subject:</span>
                <span class="highlight">{{ $contact->subject }}</span>
            </div>

            <div class="message-container">
                <span class="message-label">Message:</span>
                <div class="message-content">{{ $contact->message }}</div>
            </div>
        </div>

        <div class="footer">
            This email was sent from Smutly.
        </div>
    </div>
</body>

</html>
