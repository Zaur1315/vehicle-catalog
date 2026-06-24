<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Lead\StoreFinanceLeadRequest;
use App\Services\Lead\FinanceLeadService;
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
    ): RedirectResponse
    {
        $financeLeadService->create($request->validated());

        return back()->with('success', 'Your finance request has been sent. Our team will contact you soon.');
    }
}
