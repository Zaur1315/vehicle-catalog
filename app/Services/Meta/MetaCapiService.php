<?php

declare(strict_types=1);

namespace App\Services\Meta;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

final readonly class MetaCapiService
{
    public function sendLead(Request $request, string $formType, array $leadData = []): ?string
    {
        if (!config('services.meta.capi_enabled')) {
            return null;
        }

        $pixelId = config('services.meta.pixel_id');
        $accessToken = config('services.meta.capi_access_token');
        $graphApiVersion = config('services.meta.graph_api_version', 'v25.0');

        if (!is_string($pixelId) || $pixelId === '' || !is_string($accessToken) || $accessToken === '') {
            Log::warning('Meta CAPI skipped: pixel id or access token is missing.');

            return null;
        }

        $eventId = (string)Str::uuid();

        $userData = array_filter([
            'client_ip_address' => $request->ip(),
            'client_user_agent' => $request->userAgent(),
        ]);

        $customData = array_filter([
            'form_type' => $formType,
            'lead_type' => $formType,
            'content_name' => $leadData['content_name'] ?? null,
            'content_category' => $formType,
            'vehicle_id' => $leadData['vehicle_id'] ?? null,
            'stock_number' => $leadData['stock_number'] ?? null,
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
                'payload' => $payload,
            ]);
        }

        if (!$response->successful()) {
            Log::warning('Meta CAPI Lead failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }

        return $eventId;
    }
}
