<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $reservationCode,
        public string $fullName,
        public string $status,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Reservation update - ' . $this->reservationCode);
    }

    public function content(): Content
    {
        return new Content(view: 'mail.reservation-status');
    }
}