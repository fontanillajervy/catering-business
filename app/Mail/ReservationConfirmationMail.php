<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $reservationCode,
        public string $fullName,
        public string $eventType,
        public string $eventDate,
        public float $estimatedBudget,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Reservation request received - ' . $this->reservationCode);
    }

    public function content(): Content
    {
        return new Content(view: 'mail.reservation-confirmation');
    }
}