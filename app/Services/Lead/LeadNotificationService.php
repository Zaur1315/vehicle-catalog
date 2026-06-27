<?php

declare(strict_types=1);

namespace App\Services\Lead;

use App\Mail\LeadNotificationMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

final readonly class LeadNotificationService
{
    public function send(string $type, array $data): void
    {
        $to = config('lead.notification_email');

        Log::info('Lead notification send attempt.', [
            'type' => $type,
            'to' => $to,
            'mailer' => config('mail.default'),
        ]);

        if (!is_string($to) || trim($to) === '') {
            Log::warning('Lead notification skipped: LEAD_NOTIFICATION_EMAIL is not configured.');

            return;
        }

        try {
            Mail::to($to)->send(new LeadNotificationMail($type, $data));

            Log::info('Lead notification email sent.', [
                'type' => $type,
                'to' => $to,
            ]);
        } catch (Throwable $exception) {
            Log::error('Lead notification email failed.', [
                'type' => $type,
                'to' => $to,
                'class' => $exception::class,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
