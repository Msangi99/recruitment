<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Interview Request Approved</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9fafb; padding: 30px; border: 1px solid #e5e7eb; }
        .details { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; border: 1px solid #e5e7eb; }
        .details-row { display: flex; padding: 10px 0; border-bottom: 1px solid #f3f4f6; }
        .details-label { font-weight: bold; color: #6b7280; width: 150px; }
        .details-value { color: #111827; }
        .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 12px; }
        .badge { display: inline-block; padding: 8px 16px; background: #10B981; color: white; border-radius: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">Interview Request Approved</h1>
            <p style="margin: 10px 0 0;">Your interview request has been confirmed</p>
        </div>
        
        <div class="content">
            <p>Dear {{ $employerName ?? 'Employer' }},</p>
            
            <p>Great news! Your interview request has been <span class="badge">APPROVED</span> by our admin team.</p>
            
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
                    <span class="details-label">Date & Time:</span>
                    <span class="details-value">{{ $scheduledAt }}</span>
                </div>
                
                <div class="details-row">
                    <span class="details-label">Duration:</span>
                    <span class="details-value">{{ $duration }} minutes</span>
                </div>
                
                <div class="details-row">
                    <span class="details-label">Meeting Mode:</span>
                    <span class="details-value">{{ ucfirst($meetingMode) }}</span>
                </div>
                
                @if($meetingMode === 'online' && $meetingLink)
                <div class="details-row">
                    <span class="details-label">Meeting Link:</span>
                    <span class="details-value"><a href="{{ $meetingLink }}">{{ $meetingLink }}</a></span>
                </div>
                @endif
                
                @if($meetingMode === 'in-person' && $meetingLocation)
                <div class="details-row">
                    <span class="details-label">Location:</span>
                    <span class="details-value">{{ $meetingLocation }}</span>
                </div>
                @endif
            </div>
            
            <p><strong>Next Steps:</strong></p>
            <ul>
                <li>The candidate has been notified about this interview</li>
                <li>Please ensure you are available at the scheduled time</li>
                <li>Prepare your questions and any materials needed for the interview</li>
            </ul>
            
            <p>If you have any questions, please contact us at <a href="mailto:{{ $hrEmail ?? 'hr@implore.co.tz' }}">{{ $hrEmail ?? 'hr@implore.co.tz' }}</a></p>
            
            <p>Best regards,<br>Implore Recruitment Team</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Implore Recruitment. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
