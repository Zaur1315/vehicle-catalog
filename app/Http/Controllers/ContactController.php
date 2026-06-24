<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Lead\StoreContactLeadRequest;
use App\Services\Lead\ContactLeadService;
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
        StoreContactLeadRequest $request,
        ContactLeadService      $contactLeadService,
    ): RedirectResponse
    {
        $contactLeadService->create($request->validated());

        return back()->with('success', 'Your message has been sent. Our team will contact you soon.');
    }
}
