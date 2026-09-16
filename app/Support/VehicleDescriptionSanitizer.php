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

        if (preg_match('/<(?:p|div|h[1-6]|ul|ol|li|a|strong|em|br|blockquote|table|thead|tbody|tr|th|td)\b[^>]*>/i', $description) !== 1) {
            return sprintf(
                '<div class="vehicle-description-plain">%s</div>',
                htmlspecialchars($description, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
            );
        }

        $config = (new HtmlSanitizerConfig)
            ->allowSafeElements()
            ->allowLinkSchemes(['https', 'http', 'mailto'])
            ->allowRelativeLinks()
            ->forceAttribute('a', 'rel', 'noopener noreferrer');

        return (new HtmlSanitizer($config))->sanitize($description);
    }
}
