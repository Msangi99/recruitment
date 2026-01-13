<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Contact Form Submission</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px;">
        <div style="background-color: #4f46e5; color: white; padding: 20px; border-radius: 8px 8px 0 0; text-align: center;">
            <h1 style="margin: 0; font-size: 24px;">New Contact Form Submission</h1>
        </div>
        
        <div style="background-color: white; padding: 30px; border-radius: 0 0 8px 8px;">
            <h2 style="color: #4f46e5; margin-top: 0;">Contact Details:</h2>
            
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">
                        <strong>Name:</strong>
                    </td>
                    <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">
                        {{ $name }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">
                        <strong>Email:</strong>
                    </td>
                    <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">
                        <a href="mailto:{{ $email }}" style="color: #4f46e5;">{{ $email }}</a>
                    </td>
                </tr>
                @if(isset($phone) && $phone)
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">
                        <strong>Phone:</strong>
                    </td>
                    <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">
                        {{ $phone }}
                    </td>
                </tr>
                @endif
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">
                        <strong>Subject:</strong>
                    </td>
                    <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">
                        {{ $subject }}
                    </td>
                </tr>
            </table>

            <div style="margin-top: 20px;">
                <h3 style="color: #4f46e5; margin-bottom: 10px;">Message:</h3>
                <div style="background-color: #f9fafb; padding: 15px; border-left: 4px solid #4f46e5; border-radius: 4px;">
                    {!! nl2br(e($message)) !!}
                </div>
            </div>

            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; text-align: center; color: #6b7280; font-size: 14px;">
                <p>This message was sent via the COYZON contact form on {{ date('F d, Y \a\t h:i A') }}</p>
                <p style="margin-top: 10px;">
                    <a href="mailto:{{ $email }}" style="color: #4f46e5; text-decoration: none;">Reply to this email</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
