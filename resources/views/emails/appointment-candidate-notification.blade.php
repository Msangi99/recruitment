<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Interview Scheduled</title>
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
        .cta-button { display: inline-block; padding: 15px 30px; background: #4F46E5; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">🎉 Interview Scheduled!</h1>
            <p style="margin: 10px 0 0;">An employer wants to interview you</p>
        </div>
        
        <div class="content">
            <p>Dear {{ $candidateName }},</p>
            
            <p>Great news! An employer is interested in interviewing you. The interview has been <span class="badge">CONFIRMED</span>.</p>
            
            <div class="details">
                <h3 style="margin-top: 0; color: #4F46E5;">Interview Details</h3>
                
                <div class="details-row">
                    <span class="details-label">Company:</span>
                    <span class="details-value">{{ $companyName }}</span>
                </div>
                
                <div class="details-row">
                    <span class="details-label">Position:</span>
                    <span class="details-value">{{ $jobTitle }}</span>
                </div>
                
                <div class="details-row">
                    <span class="details-label">Date & Time:</span>
                    <span class="details-value"><strong>{{ $scheduledAt }}</strong></span>
                </div>
                
                <div class="details-row">
                    <span class="details-label">Duration:</span>
                    <span class="details-value">{{ $duration }} minutes</span>
                </div>
                
                <div class="details-row">
                    <span class="details-label">Interview Type:</span>
                    <span class="details-value">{{ ucfirst($meetingMode) }}</span>
                </div>
                
                @if($meetingMode === 'online' && $meetingLink)
                <div class="details-row">
                    <span class="details-label">Meeting Link:</span>
                    <span class="details-value"><a href="{{ $meetingLink }}" style="color: #4F46E5;">Join Meeting</a></span>
                </div>
                @endif
                
                @if($meetingMode === 'in-person' && $meetingLocation)
                <div class="details-row">
                    <span class="details-label">Location:</span>
                    <span class="details-value">{{ $meetingLocation }}</span>
                </div>
                @endif
                
                @if($requirements)
                <div class="details-row">
                    <span class="details-label">Requirements:</span>
                    <span class="details-value">{{ $requirements }}</span>
                </div>
                @endif
                
                @if($notes)
                <div class="details-row">
                    <span class="details-label">Notes:</span>
                    <span class="details-value">{{ $notes }}</span>
                </div>
                @endif
            </div>
            
            <p style="text-align: center;">
                <a href="{{ url('/candidate/dashboard') }}" class="cta-button">View in Dashboard</a>
            </p>
            
            <p><strong>Tips for your interview:</strong></p>
            <ul>
                <li>Be on time - log in or arrive 5-10 minutes early</li>
                <li>Dress professionally</li>
                <li>Prepare questions about the role and company</li>
                <li>Have your documents ready if requested</li>
                @if($meetingMode === 'online')
                <li>Test your camera and microphone before the meeting</li>
                @endif
            </ul>
            
            <p>Good luck with your interview!</p>
            
            <p>Best regards,<br>Implore Recruitment Team</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Implore Recruitment. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
