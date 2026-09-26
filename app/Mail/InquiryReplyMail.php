<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InquiryReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $fullName,
        public string $inquirySubject,
        public string $reply,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Re: ' . $this->inquirySubject);
    }

    public function content(): Content
    {
        return new Content(view: 'mail.inquiry-reply');
    }
}