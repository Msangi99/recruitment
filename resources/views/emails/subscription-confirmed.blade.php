<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Activated - {{ config('app.name') }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
        <h1 style="color: white; margin: 0;">COYZON</h1>
    </div>
    
    <div style="background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px;">
        <h2 style="color: #333; margin-top: 0;">Subscription Activated</h2>
        
        <p>Dear {{ $user->name }},</p>
        
        <p>Congratulations! Your subscription has been successfully activated.</p>
        
        <div style="background: white; padding: 20px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #667eea;">
            <h3 style="margin-top: 0; color: #667eea;">Subscription Details</h3>
            <p><strong>Plan:</strong> {{ $appointment->notes ?? 'Premium Plan' }}</p>
            <p><strong>Amount Paid:</strong> {{ $appointment->currency }} {{ number_format($appointment->amount, 2) }}</p>
            <p><strong>Activated:</strong> {{ $appointment->confirmed_at->format('F d, Y') }}</p>
            @if($appointment->scheduled_at)
            <p><strong>Expires:</strong> {{ $appointment->scheduled_at->format('F d, Y') }}</p>
            @endif
            <p><strong>Transaction ID:</strong> {{ $appointment->transaction_id ?? $appointment->order_id }}</p>
        </div>
        
        <p>You now have access to all premium features. Enjoy unlimited consultations and priority support!</p>
        
        <div style="margin-top: 30px; padding: 15px; background: #e8f4f8; border-radius: 5px;">
            <p style="margin: 0; font-size: 14px; color: #2c5282;">
                <strong>What's Next?</strong><br>
                You can now book consultations without individual payments. Visit your dashboard to schedule your first consultation.
            </p>
        </div>
        
        <p style="margin-top: 30px;">Best regards,<br>The COYZON Team</p>
    </div>
</body>
</html>
