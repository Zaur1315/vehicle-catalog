<?php

declare(strict_types=1);

namespace App\Support;

final class SiteUrl
{
    public static function to(string $path = '/'): string
    {
        $domain = (string) config('site.domain');
        $origin = str_starts_with($domain, 'http') ? $domain : 'https://'.$domain;

        return rtrim($origin, '/').'/'.ltrim($path, '/');
    }
}
