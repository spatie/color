<?php

namespace Spatie\Color;

use ReflectionClass;
use Spatie\Color\Exceptions\InvalidColorValue;

class Factory
{
    const EXCLUDED_FILES = ['.', '..'];

    public static function fromString(string $string): Color
    {
        $colorClasses = self::getColorClasses();

        foreach ($colorClasses as $colorClass) {
            try {
                return call_user_func("$colorClass::fromString", $string);
            } catch (InvalidColorValue $e) {
                // Catch the exception but never throw it.
            }
        }

        throw InvalidColorValue::malformedColorString($string);
    }

    protected static function getColorClasses(): array
    {
        return [
            Hex::class,
            Rgb::class,
            Rgba::class,
        ];
    }
}
