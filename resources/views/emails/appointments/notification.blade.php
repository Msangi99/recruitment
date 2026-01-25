<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Appointment Request</title>
</head>

<body
    style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #1e293b; background-color: #f8fafc; margin: 0; padding: 0;">
    <div
        style="max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); border: 1px solid #e2e8f0;">
        {{-- Branded Header --}}
        <div style="background-color: #0f172a; padding: 32px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -0.025em;">Coyzon
                Recruitment</h1>
            <p style="color: #94a3b8; margin: 8px 0 0 0; font-size: 14px; font-weight: 500;">New Booking Notification
            </p>
        </div>

        <div style="padding: 40px;">
            <div style="margin-bottom: 32px;">
                <h2 style="color: #0f172a; margin: 0 0 12px 0; font-size: 20px; font-weight: 700;">Hello HR Team,</h2>
                <p style="margin: 0; color: #64748b;">A new consultation request has been received from the website.
                    Please review the details below and take appropriate action in the admin dashboard.</p>
            </div>

            <div style="background-color: #f1f5f9; border-radius: 12px; padding: 24px; margin-bottom: 32px;">
                <div style="display: flex; align-items: center; margin-bottom: 20px;">
                    <span
                        style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Request
                        Category</span>
                </div>

                <div style="margin-bottom: 24px;">
                    <span style="display: inline-block; padding: 6px 12px; border-radius: 9999px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.025em; 
                        @if($data->type == 'employer') background-color: #dbeafe; color: #1e40af; 
                        @elseif($data->type == 'partnership') background-color: #f3e8ff; color: #6b21a8; 
                        @else background-color: #dcfce7; color: #166534; @endif">
                        {{ str_replace('_', ' ', $data->type) }}
                    </span>
                </div>

                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; font-size: 13px; font-weight: 600; color: #64748b; width: 120px;">
                            Requested By:</td>
                        <td style="padding: 8px 0; font-size: 14px; font-weight: 700; color: #0f172a;">{{ $data->name }}
                        </td>
                    </tr>
                    @if($data->company)
                        <tr>
                            <td style="padding: 8px 0; font-size: 13px; font-weight: 600; color: #64748b;">Company:</td>
                            <td style="padding: 8px 0; font-size: 14px; font-weight: 700; color: #0f172a;">
                                {{ $data->company }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td style="padding: 8px 0; font-size: 13px; font-weight: 600; color: #64748b;">Email Addr:</td>
                        <td style="padding: 8px 0; font-size: 14px; font-weight: 500; color: #2563eb;">
                            {{ $data->email }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-size: 13px; font-weight: 600; color: #64748b;">Phone Nom:</td>
                        <td style="padding: 8px 0; font-size: 14px; font-weight: 700; color: #0f172a;">
                            {{ $data->phone ?? 'N/A' }}</td>
                    </tr>
                    @if($data->requested_date)
                        <tr>
                            <td style="padding: 8px 0; font-size: 13px; font-weight: 600; color: #64748b;">Proposed Date:
                            </td>
                            <td style="padding: 8px 0; font-size: 14px; font-weight: 700; color: #0f172a;">
                                {{ \Carbon\Carbon::parse($data->requested_date)->format('M d, Y @ h:i A') }}</td>
                        </tr>
                    @endif
                </table>
            </div>

            @if($data->meta_data)
                @php $metaData = json_decode($data->meta_data, true); @endphp
                @if(is_array($metaData) && count($metaData) > 0)
                    <div style="margin-bottom: 32px;">
                        <h4
                            style="font-size: 12px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 12px 0;">
                            Additional Context:</h4>
                        <div style="border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;">
                            @foreach($metaData as $key => $value)
                                <div
                                    style="padding: 12px; border-bottom: 1px solid #f1f5f9; background-color: {{ $loop->index % 2 == 0 ? '#ffffff' : '#f8fafc' }};">
                                    <span
                                        style="display: block; font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 2px;">{{ str_replace('_', ' ', $key) }}</span>
                                    <span style="display: block; font-size: 13px; color: #334155; font-weight: 500;">
                                        @if(is_array($value)) {{ json_encode($value) }} @else {{ $value }} @endif
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            <div style="text-align: center; margin-top: 40px;">
                <a href="{{ url('/admin/consultations') }}"
                    style="display: inline-block; background-color: #2563eb; color: #ffffff; padding: 16px 32px; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);">
                    View in Dashboard
                </a>
            </div>
        </div>

        <div style="background-color: #f8fafc; padding: 24px; text-align: center; border-top: 1px solid #e2e8f0;">
            <p style="margin: 0; font-size: 12px; color: #94a3b8;">This is an automated notification from the Coyzon
                Recruitment Platform.</p>
        </div>
    </div>
</body>

</html>