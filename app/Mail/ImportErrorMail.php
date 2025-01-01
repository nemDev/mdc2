<?php

namespace App\Mail;

use App\Models\Upload;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ImportErrorMail extends Mailable
{
    use Queueable, SerializesModels;

    public $upload;
    /**
     * Create a new message instance.
     */
    public function __construct(Upload $upload)
    {
        $this->upload = $upload;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Import Error Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.import-error-mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build(){
        return $this->from('test@test.com', "Import failure")
            ->markdown('mail.import-error-mail');
    }
}
