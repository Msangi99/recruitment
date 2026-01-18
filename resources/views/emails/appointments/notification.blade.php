<!DOCTYPE html>
<html>

<head>
    <title>New Appointment Request</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2 style="color: #2563eb;">New Appointment Notification</h2>

    <p>Hello HR Team,</p>

    <p>A new appointment/consultation request has been submitted via the website.</p>

    <div style="background-color: #f3f4f6; padding: 20px; border-radius: 8px; margin: 20px 0;">
        <h3 style="margin-top: 0;">Request Details:</h3>

        <table style="width: 100%; text-align: left; border-collapse: collapse;">
            <tr>
                <td style="padding: 8px 0; font-weight: bold; width: 150px;">Type:</td>
                <td style="padding: 8px 0;">{{ ucfirst(str_replace('_', ' ', $data->type)) }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-weight: bold;">Name:</td>
                <td style="padding: 8px 0;">{{ $data->name }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-weight: bold;">Email:</td>
                <td style="padding: 8px 0;">{{ $data->email }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-weight: bold;">Phone:</td>
                <td style="padding: 8px 0;">{{ $data->phone ?? 'N/A' }}</td>
            </tr>

            @if($data->company)
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Company:</td>
                    <td style="padding: 8px 0;">{{ $data->company }}</td>
                </tr>
            @endif

            @if($data->country)
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Country:</td>
                    <td style="padding: 8px 0;">{{ $data->country }}</td>
                </tr>
            @endif

            @if($data->requested_date)
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Requested Date:</td>
                    <td style="padding: 8px 0;">{{ $data->requested_date }}</td>
                </tr>
            @endif
        </table>

        @if($data->meta_data)
            <h4 style="margin-top: 20px; margin-bottom: 10px;">Additional Information:</h4>
            <pre
                style="background: #e5e7eb; padding: 10px; border-radius: 4px; overflow-x: auto;">{{ json_encode(json_decode($data->meta_data), JSON_PRETTY_PRINT) }}</pre>
        @endif
    </div>

    <p>Please log in to the admin dashboard to review and manage this request.</p>

    <p>Best regards,<br>
        Coyzon System</p>
</body>

</html>