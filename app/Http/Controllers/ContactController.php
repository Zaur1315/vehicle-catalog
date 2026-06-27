<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Lead\StoreContactLeadRequest;
use App\Services\Lead\ContactLeadFormTypeResolver;
use App\Services\Lead\ContactLeadService;
use App\Services\Lead\LeadNotificationService;
use App\Services\Lead\LeadTrackingService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class ContactController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Contact');
    }

    public function store(
        StoreContactLeadRequest     $request,
        ContactLeadService          $contactLeadService,
        ContactLeadFormTypeResolver $formTypeResolver,
        LeadTrackingService         $leadTrackingService,
        LeadNotificationService     $leadNotificationService
    ): RedirectResponse
    {
        $validated = $request->validated();

        $contactLeadService->create($validated);

        $formType = $formTypeResolver->resolve($validated['subject'] ?? null);

        $metaEvent = $leadTrackingService->track($request, $formType, [
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'] ?? null,
        ]);

        $leadNotificationService->send('Contact', $validated);

        return back()->with([
            'success' => 'Your message has been sent. Our team will contact you soon.',
            'meta_event' => $metaEvent,
        ]);
    }
}
