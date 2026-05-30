@php
    $variant = $variant ?? 'info';
    $styles = [
        'info' => ['bg' => '#eff6ff', 'border' => '#bfdbfe', 'title' => '#1d4ed8'],
        'success' => ['bg' => '#ecfdf5', 'border' => '#a7f3d0', 'title' => '#047857'],
        'warning' => ['bg' => '#fffbeb', 'border' => '#fde68a', 'title' => '#b45309'],
        'danger' => ['bg' => '#fef2f2', 'border' => '#fecaca', 'title' => '#b91c1c'],
    ];
    $s = $styles[$variant] ?? $styles['info'];
@endphp
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin: 24px 0; background-color: {{ $s['bg'] }}; border: 1px solid {{ $s['border'] }}; border-radius: 12px;">
    <tr>
        <td style="padding: 18px 20px;">
            @if(!empty($title))
                <p style="margin: 0 0 8px; font-size: 13px; font-weight: 700; color: {{ $s['title'] }};">{{ $title }}</p>
            @endif
            <div style="font-size: 14px; line-height: 1.6; color: #334155;">
                {!! $body !!}
            </div>
        </td>
    </tr>
</table>
