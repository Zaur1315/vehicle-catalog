<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),

            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
                'meta_event' => fn () => $request->session()->get('meta_event'),
            ],

            'site' => [
                'name' => config('site.name'),
                'tagline' => config('site.tagline'),
                'phone' => config('site.phone'),
                'phone_tel' => config('site.phone_tel'),
                'email' => config('site.email'),
                'address' => config('site.address'),
                'maps_url' => config('site.maps_url'),
                'maps_embed_url' => config('site.maps_embed_url'),
                'city' => config('site.city'),
                'state' => config('site.state'),
                'zip' => config('site.zip'),
                'country' => config('site.country'),
                'business_hours' => config('site.business_hours'),
                'logo' => config('site.logo'),
            ],

            'tracking' => [
                'meta_pixel_id' => config('services.meta.pixel_id'),
                'meta_pixel_enabled' => config('services.meta.pixel_enabled'),
            ],
        ];
    }
}
