<?php

namespace App\Mail;

// use App\Models\Resume;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResumeSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $resumeUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $resumeUrl)
    {
        $this->name = $name;
        $this->resumeUrl = $resumeUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Resume Submission')->view('emails.resume_submission_alert')->with([
            'name' => $this->name,
            'resumeUrl' => asset($this->resumeUrl),
        ]);
    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Resume Submitted',
    //     );
    // }

    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    // public function attachments(): array
    // {
    //     return [];
    // }
}
