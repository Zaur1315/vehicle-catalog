<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Lead\StoreFinanceLeadRequest;
use App\Services\Lead\FinanceLeadService;
use App\Services\Lead\LeadTrackingService;
use App\Support\LeadFormType;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class FinanceController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Finance');
    }

    public function store(
        StoreFinanceLeadRequest $request,
        FinanceLeadService      $financeLeadService,
        LeadTrackingService     $leadTrackingService,
    ): RedirectResponse
    {
        $validated = $request->validated();

        $financeLeadService->create($validated);

        $metaEvent = $leadTrackingService->track($request, LeadFormType::FINANCE, [
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'content_name' => 'Finance Request',
        ]);

        return back()->with([
            'success' => 'Your finance request has been sent. Our team will contact you soon.',
            'meta_event' => $metaEvent,
        ]);
    }
}
