<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Lead\StoreTradeInLeadRequest;
use App\Services\Lead\LeadNotificationService;
use App\Services\Lead\LeadTrackingService;
use App\Services\Lead\TradeInLeadService;
use App\Support\LeadFormType;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class TradeInController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('TradeIn');
    }

    public function store(
        StoreTradeInLeadRequest $request,
        TradeInLeadService      $tradeInLeadService,
        LeadTrackingService     $leadTrackingService,
        LeadNotificationService $leadNotificationService,
    ): RedirectResponse
    {
        $validated = $request->validated();

        $tradeInLeadService->create($validated);

        $metaEvent = $leadTrackingService->track($request, LeadFormType::TRADE_IN, [
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'content_name' => 'Trade-In Request',
        ]);

        $leadNotificationService->send('Trade-In', $validated);

        return back()->with([
            'success' => 'Your trade-in request has been sent. Our team will contact you soon.',
            'meta_event' => $metaEvent,
        ]);
    }
}
