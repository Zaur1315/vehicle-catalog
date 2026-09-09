<?php

declare(strict_types=1);

namespace App\Services\Lead;

use App\Services\Meta\MetaCapiService;
use App\Support\LeadFormType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

final readonly class LeadTrackingService
{
    public function __construct(
        private MetaCapiService $metaCapiService,
    ) {}

    public function track(Request $request, string $formType, array $leadData = []): array
    {
        $eventId = (string) Str::uuid();

        try {
            $this->metaCapiService->sendLead(
                request: $request,
                eventId: $eventId,
                formType: $formType,
                leadData: [
                    ...$leadData,
                    'content_name' => $leadData['content_name'] ?? LeadFormType::label($formType),
                ],
            );
        } catch (Throwable $exception) {
            Log::warning('Lead tracking failed after lead persistence.', [
                'exception' => $exception::class,
                'event_id' => $eventId,
            ]);
        }

        return [
            'event_name' => 'Lead',
            'event_id' => $eventId,
            'form_type' => $formType,
        ];
    }
}
