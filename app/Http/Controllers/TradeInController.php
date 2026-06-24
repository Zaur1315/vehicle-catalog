<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Lead\StoreTradeInLeadRequest;
use App\Services\Lead\TradeInLeadService;
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
    ): RedirectResponse
    {
        $tradeInLeadService->create($request->validated());

        return back()->with('success', 'Your trade-in request has been sent. Our team will contact you soon.');
    }
}
