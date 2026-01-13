<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Interview Request Cancelled</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9fafb; padding: 30px; border: 1px solid #e5e7eb; }
        .details { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; border: 1px solid #e5e7eb; }
        .details-row { display: flex; padding: 10px 0; border-bottom: 1px solid #f3f4f6; }
        .details-label { font-weight: bold; color: #6b7280; width: 150px; }
        .details-value { color: #111827; }
        .reason-box { background: #FEF2F2; border: 1px solid #FECACA; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 12px; }
        .badge { display: inline-block; padding: 8px 16px; background: #EF4444; color: white; border-radius: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">Interview Request Cancelled</h1>
            <p style="margin: 10px 0 0;">Your interview request could not be approved</p>
        </div>
        
        <div class="content">
            <p>Dear {{ $employerName ?? 'Employer' }},</p>
            
            <p>We regret to inform you that your interview request has been <span class="badge">CANCELLED</span>.</p>
            
            <div class="details">
                <h3 style="margin-top: 0; color: #4F46E5;">Interview Details</h3>
                
                <div class="details-row">
                    <span class="details-label">Candidate:</span>
                    <span class="details-value">{{ $candidateName }}</span>
                </div>
                
                <div class="details-row">
                    <span class="details-label">Position:</span>
                    <span class="details-value">{{ $jobTitle }}</span>
                </div>
                
                <div class="details-row">
                    <span class="details-label">Company:</span>
                    <span class="details-value">{{ $companyName }}</span>
                </div>
                
                <div class="details-row">
                    <span class="details-label">Scheduled Date:</span>
                    <span class="details-value">{{ $scheduledAt }}</span>
                </div>
            </div>
            
            @if($cancellationReason)
            <div class="reason-box">
                <h4 style="margin-top: 0; color: #DC2626;">Reason for Cancellation:</h4>
                <p style="margin-bottom: 0;">{{ $cancellationReason }}</p>
            </div>
            @endif
            
            <p><strong>What can you do next?</strong></p>
            <ul>
                <li>You can submit a new interview request for another candidate</li>
                <li>Browse our candidate database at <a href="{{ url('/candidates') }}">{{ url('/candidates') }}</a></li>
                <li>Contact us if you have any questions about this decision</li>
            </ul>
            
            <p>If you have any questions, please contact us at <a href="mailto:{{ $hrEmail ?? 'hr@implore.co.tz' }}">{{ $hrEmail ?? 'hr@implore.co.tz' }}</a></p>
            
            <p>We apologize for any inconvenience caused.</p>
            
            <p>Best regards,<br>Implore Recruitment Team</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Implore Recruitment. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
