<?php

declare(strict_types=1);

namespace App\Services\Lead;

use App\Services\Meta\MetaCapiService;
use App\Support\LeadFormType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

final readonly class LeadTrackingService
{
    public function __construct(
        private MetaCapiService $metaCapiService,
    )
    {
    }

    public function track(Request $request, string $formType, array $leadData = []): array
    {
        $eventId = (string)Str::uuid();

        $this->metaCapiService->sendLead(
            request: $request,
            eventId: $eventId,
            formType: $formType,
            leadData: [
                ...$leadData,
                'content_name' => $leadData['content_name'] ?? LeadFormType::label($formType),
            ],
        );

        return [
            'event_name' => 'Lead',
            'event_id' => $eventId,
            'form_type' => $formType,
        ];
    }
}
