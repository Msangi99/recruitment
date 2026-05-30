<?php

namespace App\Mail;

use App\Models\CandidateProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProfileVerificationUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public CandidateProfile $profile,
        public ?string $reason = null,
    ) {
        $this->profile->loadMissing('user');
    }

    public function envelope(): Envelope
    {
        $status = ucfirst($this->profile->verification_status);

        return new Envelope(
            subject: "Profile {$status} - " . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.profile.verification-updated',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
