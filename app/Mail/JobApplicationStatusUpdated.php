<?php

namespace App\Mail;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobApplicationStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public JobApplication $application,
        public string $previousStatus,
    ) {
        $this->application->loadMissing(['job', 'candidate']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Application Update: ' . ucfirst($this->application->status) . ' - ' . $this->application->job->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.jobs.status-updated',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
