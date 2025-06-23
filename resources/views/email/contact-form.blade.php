<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    // Properti untuk menyimpan data dari form
    public $senderName;
    public $senderEmail;
    public $senderMessage;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $email, $message)
    {
        $this->senderName = $name;
        $this->senderEmail = $email;
        $this->senderMessage = $message;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            replyTo: [
                new Address($this->senderEmail, $this->senderName),
            ],
            subject: 'Pesan Baru dari Form Kontak Website',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact-form',
            with: [
                'name' => $this->senderName,
                'email' => $this->senderEmail,
                'messageContent' => $this->senderMessage,
            ],
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
}
