<?php

namespace Spatie\Color;

use Spatie\Color\Exceptions\InvalidColorValue;

class Factory
{
    public static function fromString(string $string): Color
    {
        $colorClasses = static::getColorClasses();

        foreach ($colorClasses as $colorClass) {
            try {
                return $colorClass::fromString($string);
            } catch (InvalidColorValue $e) {
                // Catch the exception but never throw it.
            }
        }

        throw InvalidColorValue::malformedColorString($string);
    }

    protected static function getColorClasses(): array
    {
        return [
            CIELab::class,
            Cmyk::class,
            Hex::class,
            Hsl::class,
            Hsla::class,
            Rgb::class,
            Rgba::class,
            Xyz::class,
        ];
    }
}
