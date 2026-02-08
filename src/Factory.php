<?php

namespace Spatie\Color;

use Spatie\Color\Exceptions\InvalidColorValue;

final class Factory
{
    public static function fromString(string $string): Color
    {
        $colorClasses = self::getColorClasses();

        foreach ($colorClasses as $colorClass) {
            try {
                return $colorClass::fromString($string);
            } catch (InvalidColorValue) {
                // Catch the exception but never throw it.
            }
        }

        throw InvalidColorValue::malformedColorString($string);
    }

    /** @return array<class-string<Color>> */
    private static function getColorClasses(): array
    {
        return [
            Named::class,
            Argb::class,
            CIELab::class,
            Cmyk::class,
            Hex::class,
            Hsb::class,
            Hsl::class,
            Hsla::class,
            Rgb::class,
            Rgba::class,
            Xyz::class,
        ];
    }
}
