<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

final class LeadNotificationMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly string $type,
        public readonly array  $data,
    )
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                config('mail.from.address'),
                config('mail.from.name'),
            ),
            replyTo: $this->replyToAddress(),
            subject: sprintf('[Marick Auto Sales] New %s lead', $this->type),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.leads.notification',
        );
    }

    private function replyToAddress(): array
    {
        $email = $this->data['email'] ?? null;

        if (!is_string($email) || trim($email) === '') {
            return [];
        }

        $name = trim(sprintf(
            '%s %s',
            $this->data['first_name'] ?? '',
            $this->data['last_name'] ?? '',
        ));

        return [
            new Address($email, $name !== '' ? $name : $email),
        ];
    }
}
