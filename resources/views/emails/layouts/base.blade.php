@php
    $tone = $tone ?? 'brand';
    $tones = [
        'brand' => ['from' => '#105e46', 'to' => '#059669', 'accent' => '#105e46', 'soft' => '#ECFDF5'],
        'success' => ['from' => '#059669', 'to' => '#10B981', 'accent' => '#059669', 'soft' => '#ECFDF5'],
        'danger' => ['from' => '#DC2626', 'to' => '#EF4444', 'accent' => '#DC2626', 'soft' => '#FEF2F2'],
        'warning' => ['from' => '#D97706', 'to' => '#F59E0B', 'accent' => '#B45309', 'soft' => '#FFFBEB'],
        'dark' => ['from' => '#0F172A', 'to' => '#1E293B', 'accent' => '#2563EB', 'soft' => '#F1F5F9'],
    ];
    $palette = $tones[$tone] ?? $tones['brand'];
    $appName = config('app.name', 'Coyzon');
    $preheader = $preheader ?? '';
    $heroTitle = $heroTitle ?? $title ?? $appName;
    $heroSubtitle = $heroSubtitle ?? 'Professional Overseas Recruitment';
    $hideHeaderBrand = $hideHeaderBrand ?? false;
    $title = $title ?? $heroTitle;
@endphp
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>{{ $title }}</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style>
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        body { margin: 0 !important; padding: 0 !important; width: 100% !important; }
        a[x-apple-data-detectors] { color: inherit !important; text-decoration: none !important; }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #eef2f7; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
@if($preheader !== '')
    <div style="display: none; max-height: 0; overflow: hidden; mso-hide: all; opacity: 0; color: transparent; height: 0; width: 0;">
        {{ $preheader }}&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
    </div>
@endif

<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #eef2f7;">
    <tr>
        <td align="center" style="padding: 32px 16px;">
            <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="width: 100%; max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0;">

                {{-- Header --}}
                <tr>
                    <td style="background: linear-gradient(135deg, {{ $palette['from'] }} 0%, {{ $palette['to'] }} 100%); background-color: {{ $palette['from'] }}; padding: 36px 32px; text-align: center;">
                        @if(empty($hideHeaderBrand))
                            <p style="margin: 0 0 8px; font-size: 11px; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: rgba(255,255,255,0.82);">
                                {{ $appName }}
                            </p>
                        @endif
                        <h1 style="margin: 0; font-size: 26px; line-height: 1.25; font-weight: 700; color: #ffffff;">
                            {{ $heroTitle }}
                        </h1>
                        @if(!empty($heroSubtitle))
                            <p style="margin: 10px 0 0; font-size: 15px; line-height: 1.5; color: rgba(255,255,255,0.9);">
                                {{ $heroSubtitle }}
                            </p>
                        @endif
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="padding: 36px 32px; color: #334155; font-size: 15px; line-height: 1.65;">
                        @yield('content')
                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="padding: 24px 32px; background-color: #f8fafc; border-top: 1px solid #e2e8f0; text-align: center;">
                        <p style="margin: 0 0 6px; font-size: 13px; font-weight: 600; color: #475569;">
                            {{ $appName }}
                        </p>
                        <p style="margin: 0 0 12px; font-size: 12px; line-height: 1.5; color: #94a3b8;">
                            Professional Overseas Recruitment &middot; Dar es Salaam, Tanzania
                        </p>
                        <p style="margin: 0; font-size: 11px; color: #cbd5e1;">
                            &copy; {{ date('Y') }} {{ $appName }}. All rights reserved.
                        </p>
                        @hasSection('footer_note')
                            <p style="margin: 14px 0 0; font-size: 11px; line-height: 1.5; color: #94a3b8;">
                                @yield('footer_note')
                            </p>
                        @endif
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
