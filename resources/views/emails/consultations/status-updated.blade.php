<!DOCTYPE html>
<html>

<head>
    <title>Consultation Status Update</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2 style="color: #2563eb;">Consultation Status Update</h2>

    <p>Dear {{ $consultation->name }},</p>

    <p>The status of your consultation request with Coyzon has been updated.</p>

    <div style="background-color: #f3f4f6; padding: 20px; border-radius: 8px; margin: 20px 0;">
        <p><strong>Current Status:</strong> <span
                style="text-transform: uppercase; font-weight: bold; color: {{ $consultation->status == 'confirmed' ? '#16a34a' : ($consultation->status == 'cancelled' ? '#dc2626' : '#2563eb') }}">{{ str_replace('_', ' ', $consultation->status) }}</span>
        </p>

        @if($consultation->requested_date)
            <p><strong>Scheduled Date:</strong> {{ $consultation->requested_date->format('F d, Y h:i A') }}</p>
        @endif
    </div>

    @if($consultation->status == 'confirmed')
        <p>Your appointment is confirmed. We look forward to meeting with you.</p>
    @elseif($consultation->status == 'cancelled')
        <p>We regret to inform you that your appointment has been cancelled. Please contact us if you have any questions.
        </p>
    @else
        <p>We will keep you updated on any further changes.</p>
    @endif

    <p>Best regards,<br>
        Coyzon Team</p>
</body>

</html>