<?php

namespace App\Mail;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobApplicationSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public JobApplication $application)
    {
        $this->application->loadMissing(['job', 'candidate']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Application Received: ' . $this->application->job->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.jobs.application-submitted',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
