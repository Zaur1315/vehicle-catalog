<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Response;

final class RobotsController extends Controller
{
    public function __invoke(): Response
    {
        $content = implode("\n", [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin',
            'Disallow: /login',
            '',
            sprintf('Sitemap: %s', url('/sitemap.xml')),
            '',
        ]);

        return response($content, 200)
            ->header('Content-Type', 'text/plain');
    }
}
