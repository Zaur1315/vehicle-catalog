<?php

declare(strict_types=1);

namespace App\Support;

use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

final class VehicleDescriptionSanitizer
{
    public static function sanitize(?string $description): string
    {
        if ($description === null || $description === '') {
            return '';
        }

        $config = (new HtmlSanitizerConfig)
            ->allowSafeElements()
            ->allowLinkSchemes(['https', 'http', 'mailto'])
            ->allowRelativeLinks()
            ->forceAttribute('a', 'rel', 'noopener noreferrer');

        return (new HtmlSanitizer($config))->sanitize($description);
    }
}
