<?php

declare(strict_types=1);

namespace App\Services\Meta;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final readonly class MetaCapiService
{
    public function sendLead(
        Request $request,
        string  $eventId,
        string  $formType,
        array   $leadData = [],
    ): void
    {

        if ($request->cookie('cookie_marketing_consent') !== '1') {
            Log::info('Meta CAPI skipped: marketing consent was not granted.');

            return;
        }

        if (!config('services.meta.capi_enabled')) {
            return;
        }

        $pixelId = config('services.meta.pixel_id');
        $accessToken = config('services.meta.capi_access_token');
        $graphApiVersion = config('services.meta.graph_api_version', 'v25.0');

        if (!is_string($pixelId) || $pixelId === '' || !is_string($accessToken) || $accessToken === '') {
            Log::warning('Meta CAPI skipped: pixel id or access token is missing.');

            return;
        }

        $userData = array_filter([
            'client_ip_address' => $request->ip(),
            'client_user_agent' => $request->userAgent(),
            'em' => $this->hashEmail($leadData['email'] ?? null),
            'ph' => $this->hashPhone($leadData['phone'] ?? null),
        ]);

        $customData = array_filter([
            'form_type' => $formType,
            'lead_type' => $formType,
            'content_name' => $leadData['content_name'] ?? null,
            'content_category' => $formType,
            'vehicle_id' => $leadData['vehicle_id'] ?? null,
            'stock_number' => $leadData['stock_number'] ?? null,
            'subject' => $leadData['subject'] ?? null,
        ]);

        $payload = [
            'data' => [
                [
                    'event_name' => 'Lead',
                    'event_time' => time(),
                    'event_id' => $eventId,
                    'action_source' => 'website',
                    'event_source_url' => $request->headers->get('referer') ?: $request->fullUrl(),
                    'user_data' => $userData,
                    'custom_data' => $customData,
                ],
            ],
        ];

        $testEventCode = config('services.meta.capi_test_event_code');

        if (is_string($testEventCode) && $testEventCode !== '') {
            $payload['test_event_code'] = $testEventCode;
        }

        $response = Http::post(
            sprintf(
                'https://graph.facebook.com/%s/%s/events?access_token=%s',
                $graphApiVersion,
                $pixelId,
                $accessToken,
            ),
            $payload,
        );

        if (config('services.meta.capi_debug') || !$response->successful()) {
            Log::info('Meta CAPI Lead response', [
                'status' => $response->status(),
                'body' => $response->json(),
                'form_type' => $formType,
                'event_id' => $eventId,
            ]);
        }

        if (!$response->successful()) {
            Log::warning('Meta CAPI Lead failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }
    }

    private function hashEmail(mixed $email): ?array
    {
        if (!is_string($email) || trim($email) === '') {
            return null;
        }

        return [
            hash('sha256', strtolower(trim($email))),
        ];
    }

    private function hashPhone(mixed $phone): ?array
    {
        if (!is_string($phone) || trim($phone) === '') {
            return null;
        }

        $normalized = preg_replace('/\D+/', '', $phone);

        if (!is_string($normalized) || $normalized === '') {
            return null;
        }

        return [
            hash('sha256', $normalized),
        ];
    }
}
