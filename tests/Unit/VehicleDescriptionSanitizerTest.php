<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Support\VehicleDescriptionSanitizer;
use PHPUnit\Framework\TestCase;

final class VehicleDescriptionSanitizerTest extends TestCase
{
    public function test_plain_vehicle_descriptions_preserve_whitespace_and_escape_html_characters(): void
    {
        $description = "HIGHLIGHTS\n\n  - First item\n    Indented <text>";

        self::assertSame(
            '<div class="vehicle-description-plain">HIGHLIGHTS'."\n\n".'  - First item'."\n".'    Indented &lt;text&gt;</div>',
            VehicleDescriptionSanitizer::sanitize($description),
        );
    }

    public function test_html_vehicle_descriptions_continue_to_be_sanitized(): void
    {
        $html = '<p>Safe</p><script>alert(1)</script>';
        $sanitized = VehicleDescriptionSanitizer::sanitize($html);

        self::assertStringContainsString('<p>Safe</p>', $sanitized);
        self::assertStringNotContainsString('<script>', $sanitized);
    }
}
