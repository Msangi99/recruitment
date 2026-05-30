<?php

namespace App\Mail;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewJobApplication extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public JobApplication $application)
    {
        $this->application->loadMissing(['job', 'candidate']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Application: ' . $this->application->job->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.jobs.new-application',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
