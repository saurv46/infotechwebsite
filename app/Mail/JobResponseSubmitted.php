<?php

namespace App\Mail;

use App\Models\JobResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobResponseSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public JobResponse $jobResponse,
        public ?string $jobTitle = null,
    ) {
    }

    public function envelope(): Envelope
    {
        $replyTo = [];

        // Reply straight to the applicant when they left an email address.
        if (! empty($this->jobResponse->email)) {
            $replyTo[] = new Address($this->jobResponse->email, $this->jobResponse->full_name);
        }

        $position = $this->jobTitle ? ' for ' . $this->jobTitle : '';

        return new Envelope(
            subject: 'New Job Application' . $position . ': ' . $this->jobResponse->full_name,
            replyTo: $replyTo,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.job-response',
            with: [
                'jobTitle' => $this->jobTitle,
            ],
        );
    }

    /**
     * Attach the applicant's uploaded CV, when the file exists.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $path = $this->jobResponse->cv ? public_path($this->jobResponse->cv) : null;

        if ($path && is_file($path)) {
            $extension = pathinfo($path, PATHINFO_EXTENSION) ?: 'pdf';
            $niceName  = 'CV - ' . $this->jobResponse->full_name . '.' . $extension;

            return [
                Attachment::fromPath($path)->as($niceName),
            ];
        }

        return [];
    }
}
