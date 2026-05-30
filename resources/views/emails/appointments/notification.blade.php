@extends('emails.layouts.base', [
    'tone' => match ($data->type) {
        'employer' => 'brand',
        'partnership' => 'dark',
        default => 'success',
    },
    'title' => 'New Consultation Request',
    'preheader' => 'New ' . ucwords(str_replace('_', ' ', $data->type)) . ' request from ' . $data->name . '.',
    'heroTitle' => 'New Consultation Request',
    'heroSubtitle' => 'A new booking request was submitted on the website',
])

@section('content')
    @php
        $typeLabel = ucwords(str_replace('_', ' ', $data->type));
        $badgeVariant = match ($data->type) {
            'employer' => 'brand',
            'partnership' => 'neutral',
            default => 'success',
        };
    @endphp
    <p style="margin: 0 0 18px; font-size: 16px; color: #0f172a;">Hello HR Team,</p>
    <p style="margin: 0 0 16px;">A new consultation request has been received. Please review the details below.</p>

    @include('emails.partials.badge', ['text' => $typeLabel, 'variant' => $badgeVariant])

    @include('emails.partials.card-open', ['title' => 'Request Details'])
        @include('emails.partials.row', ['label' => 'Requested By', 'value' => e($data->name)])
        @if(!empty($data->company))
            @include('emails.partials.row', ['label' => 'Company', 'value' => e($data->company)])
        @endif
        @include('emails.partials.row', ['label' => 'Email', 'value' => '<a href="mailto:' . e($data->email) . '" style="color:#2563EB;text-decoration:none;font-weight:600;">' . e($data->email) . '</a>'])
        @include('emails.partials.row', ['label' => 'Phone', 'value' => e($data->phone ?? 'N/A')])
        @if(!empty($data->country))
            @include('emails.partials.row', ['label' => 'Country', 'value' => e($data->country)])
        @endif
        @if(!empty($data->requested_date))
            @include('emails.partials.row', ['label' => 'Proposed Date', 'value' => '<strong>' . e(\Carbon\Carbon::parse($data->requested_date)->format('M d, Y \a\t h:i A')) . '</strong>'])
        @endif
    @include('emails.partials.card-close')

    @if(!empty($data->meta_data))
        @php $metaData = json_decode($data->meta_data, true); @endphp
        @if(is_array($metaData) && count($metaData) > 0)
            @include('emails.partials.card-open', ['title' => 'Additional Information'])
                @foreach($metaData as $key => $value)
                    @if(filled($value))
                        @include('emails.partials.row', [
                            'label' => ucwords(str_replace('_', ' ', $key)),
                            'value' => e(is_array($value) ? json_encode($value) : $value),
                        ])
                    @endif
                @endforeach
            @include('emails.partials.card-close')
        @endif
    @endif

    @include('emails.partials.button', [
        'url' => url('/admin/consultations'),
        'label' => 'Open Admin Dashboard',
        'color' => '#2563EB',
    ])
@endsection

@section('footer_note')
    Automated notification from the Coyzon recruitment platform.
@endsection
