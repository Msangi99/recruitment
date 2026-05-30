@php
    $variant = $variant ?? 'brand';
    $styles = [
        'brand' => 'background-color: #eef2ff; color: #4338ca;',
        'success' => 'background-color: #ecfdf5; color: #047857;',
        'danger' => 'background-color: #fef2f2; color: #b91c1c;',
        'warning' => 'background-color: #fffbeb; color: #b45309;',
        'neutral' => 'background-color: #f1f5f9; color: #475569;',
    ];
    $style = $styles[$variant] ?? $styles['brand'];
@endphp
<span style="display: inline-block; padding: 6px 12px; border-radius: 999px; font-size: 11px; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase; {{ $style }}">
    {{ $text }}
</span>
