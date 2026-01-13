<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply from Implore</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
        <h1 style="color: white; margin: 0; font-size: 28px;">Implore</h1>
        <p style="color: #E0E7FF; margin: 10px 0 0 0;">Professional Overseas Recruitment</p>
    </div>
    
    <div style="background: #ffffff; padding: 30px; border: 1px solid #e5e7eb; border-top: none;">
        <p style="font-size: 16px;">Dear {{ $recipientName }},</p>
        
        <p style="font-size: 16px;">Thank you for contacting us. Here is our response to your inquiry:</p>
        
        <div style="background: #F3F4F6; padding: 20px; border-radius: 8px; margin: 20px 0;">
            {!! nl2br(e($replyMessage)) !!}
        </div>
        
        <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 30px 0;">
        
        <p style="font-size: 14px; color: #6B7280;"><strong>Your original message:</strong></p>
        <div style="background: #F9FAFB; padding: 15px; border-left: 4px solid #4F46E5; margin: 10px 0; font-size: 14px; color: #6B7280;">
            <p style="margin: 0 0 10px 0;"><strong>Subject:</strong> {{ $originalSubject }}</p>
            <p style="margin: 0;">{!! nl2br(e($originalMessage)) !!}</p>
        </div>
        
        <p style="font-size: 16px; margin-top: 30px;">If you have any further questions, please don't hesitate to reach out.</p>
        
        <p style="font-size: 16px;">
            Best regards,<br>
            <strong>The Implore Team</strong>
        </p>
    </div>
    
    <div style="background: #1F2937; padding: 20px; text-align: center; border-radius: 0 0 10px 10px;">
        <p style="color: #9CA3AF; margin: 0; font-size: 14px;">
            Implore - Professional Overseas Recruitment<br>
            Dar es Salaam, Tanzania
        </p>
        <p style="color: #6B7280; margin: 10px 0 0 0; font-size: 12px;">
            &copy; {{ date('Y') }} Implore. All rights reserved.
        </p>
    </div>
</body>
</html>
