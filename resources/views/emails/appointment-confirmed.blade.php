<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmed - COYZON</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
        <h1 style="color: white; margin: 0;">COYZON</h1>
    </div>
    
    <div style="background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px;">
        <h2 style="color: #333; margin-top: 0;">Appointment Confirmed</h2>
        
        <p>Dear {{ $user->name }},</p>
        
        <p>Your appointment has been confirmed! Payment has been received successfully.</p>
        
        <div style="background: white; padding: 20px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #667eea;">
            <h3 style="margin-top: 0; color: #667eea;">Appointment Details</h3>
            <p><strong>Type:</strong> {{ ucfirst(str_replace('-', ' ', $appointment->appointment_type)) }}</p>
            <p><strong>Date & Time:</strong> {{ $appointment->scheduled_at->format('F d, Y \a\t h:i A') }}</p>
            <p><strong>Duration:</strong> {{ $appointment->duration_minutes }} minutes</p>
            <p><strong>Mode:</strong> {{ ucfirst($appointment->meeting_mode) }}</p>
            @if($appointment->meeting_link)
            <p><strong>Meeting Link:</strong> <a href="{{ $appointment->meeting_link }}" style="color: #667eea;">{{ $appointment->meeting_link }}</a></p>
            @endif
            @if($appointment->meeting_location)
            <p><strong>Location:</strong> {{ $appointment->meeting_location }}</p>
            @endif
        </div>
        
        <p>Please make sure to be available at the scheduled time. If you need to reschedule or cancel, please contact us as soon as possible.</p>
        
        <p style="margin-top: 30px;">Best regards,<br>The COYZON Team</p>
    </div>
</body>
</html>
