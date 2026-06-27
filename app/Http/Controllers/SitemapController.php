<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Response;

final class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $staticUrls = [
            [
                'loc' => url('/'),
                'priority' => '1.0',
                'changefreq' => 'weekly',
                'lastmod' => now()->toDateString(),
            ],
            [
                'loc' => url('/inventory'),
                'priority' => '0.9',
                'changefreq' => 'daily',
                'lastmod' => now()->toDateString(),
            ],
            [
                'loc' => url('/finance'),
                'priority' => '0.7',
                'changefreq' => 'monthly',
                'lastmod' => now()->toDateString(),
            ],
            [
                'loc' => url('/trade-in'),
                'priority' => '0.7',
                'changefreq' => 'monthly',
                'lastmod' => now()->toDateString(),
            ],
            [
                'loc' => url('/delivery'),
                'priority' => '0.6',
                'changefreq' => 'monthly',
                'lastmod' => now()->toDateString(),
            ],
            [
                'loc' => url('/warranty-return'),
                'priority' => '0.6',
                'changefreq' => 'monthly',
                'lastmod' => now()->toDateString(),
            ],
            [
                'loc' => url('/about'),
                'priority' => '0.6',
                'changefreq' => 'monthly',
                'lastmod' => now()->toDateString(),
            ],
            [
                'loc' => url('/contact'),
                'priority' => '0.8',
                'changefreq' => 'monthly',
                'lastmod' => now()->toDateString(),
            ],
            [
                'loc' => url('/privacy-policy'),
                'priority' => '0.3',
                'changefreq' => 'yearly',
                'lastmod' => now()->toDateString(),
            ],
            [
                'loc' => url('/terms'),
                'priority' => '0.3',
                'changefreq' => 'yearly',
                'lastmod' => now()->toDateString(),
            ],
        ];

        $vehicles = Vehicle::query()
            ->where('is_active', true)
            ->where('status', Vehicle::STATUS_AVAILABLE)
            ->orderByDesc('updated_at')
            ->get(['slug', 'updated_at']);

        $xml = view('sitemap', [
            'staticUrls' => $staticUrls,
            'vehicles' => $vehicles,
        ])->render();

        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
}
