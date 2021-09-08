<?php

namespace Spatie\Color;

use Spatie\Color\Exceptions\InvalidColorValue;

class Validate
{
    public static function CIELabValue(float $value, string $name): void
    {
        if ($name === 'l' && ($value < 0 || $value > 100)) {
            throw InvalidColorValue::CIELabValueNotInRange($value, $name, 0, 100);
        }

        if (($name === 'a' || $name === 'b') && ($value < -110 || $value > 110)) {
            throw InvalidColorValue::CIELabValueNotInRange($value, $name, -110, 110);
        }
    }

    public static function CIELabColorString($string): void
    {
        if (! preg_match('/^ *CIELab\( *\d{1,3}\.?\d+? *, *-?\d{1,3}\.?\d+? *, *-?\d{1,3}\.?\d+? *\) *$/i', $string)) {
            throw InvalidColorValue::malformedCIELabColorString($string);
        }
    }

    public static function cmykValue(float $value, string $name): void
    {
        if ($value < 0 || $value > 1) {
            throw InvalidColorValue::cmykValueNotInRange($value, $name);
        }
    }

    public static function rgbChannelValue(int $value, string $channel): void
    {
        if ($value < 0 || $value > 255) {
            throw InvalidColorValue::rgbChannelValueNotInRange($value, $channel);
        }
    }

    public static function alphaChannelValue(float $value): void
    {
        if ($value < 0 || $value > 1) {
            throw InvalidColorValue::alphaChannelValueNotInRange($value);
        }
    }

    public static function hexChannelValue(string $value): void
    {
        if (strlen($value) !== 2) {
            throw InvalidColorValue::hexChannelValueHasInvalidLength($value);
        }

        if (! preg_match('/[a-f0-9]{2}/i', $value)) {
            throw InvalidColorValue::hexValueContainsInvalidCharacters($value);
        }
    }

    public static function hsbValue(float $value, string $name): void
    {
        switch ($name) {
            case 'hue':
                if ($value < 0 || $value > 360) {
                    throw InvalidColorValue::hsbValueNotInRange($value, $name);
                }
                break;

            default:
                if ($value < 0 || $value > 100) {
                    throw InvalidColorValue::hsbValueNotInRange($value, $name);
                }
                break;
        }
    }

    public static function hslValue(float $value, string $name): void
    {
        if ($value < 0 || $value > 100) {
            throw InvalidColorValue::hslValueNotInRange($value, $name);
        }
    }

    public static function cmykColorString($string): void {
        if (! preg_match('/^ *cmyk\( *(\d{1,3})%? *, *(\d{1,3})%? *, *(\d{1,3})%? *, *(\d{1,3})%? *\) *$/i', $string)) {
            throw InvalidColorValue::malformedCmykColorString($string);
        }
    }

    public static function rgbColorString($string): void
    {
        if (! preg_match('/^ *rgb\( *\d{1,3} *, *\d{1,3} *, *\d{1,3} *\) *$/i', $string)) {
            throw InvalidColorValue::malformedRgbColorString($string);
        }
    }

    public static function rgbaColorString($string): void
    {
        if (! preg_match('/^ *rgba\( *\d{1,3} *, *\d{1,3} *, *\d{1,3} *, *[0-1](\.\d{1,2})? *\) *$/i', $string)) {
            throw InvalidColorValue::malformedRgbaColorString($string);
        }
    }

    public static function hexColorString($string): void
    {
        if (! preg_match('/^#(?:[a-f0-9]{3}|[a-f0-9]{4}|[a-f0-9]{6}|[a-f0-9]{8})$/i', $string)) {
            throw InvalidColorValue::malformedHexColorString($string);
        }
    }

    public static function hsbColorString($string): void
    {
        if (! preg_match('/^ *hs[vb]\( *-?\d{1,3} *, *\d{1,3}%? *, *\d{1,3}%? *\) *$/i', $string)) {
            throw InvalidColorValue::malformedHslColorString($string);
        }
    }

    public static function hslColorString($string): void
    {
        if (! preg_match('/^ *hsl\( *-?\d{1,3} *, *\d{1,3}%? *, *\d{1,3}%? *\) *$/i', $string)) {
            throw InvalidColorValue::malformedHslColorString($string);
        }
    }

    public static function hslaColorString($string): void
    {
        if (! preg_match('/^ *hsla\( *\d{1,3} *, *\d{1,3}%? *, *\d{1,3}%? *, *[0-1](\.\d{1,2})? *\) *$/i', $string)) {
            throw InvalidColorValue::malformedHslaColorString($string);
        }
    }

    public static function xyzValue(float $value, string $name): void
    {
        if ($name === 'x' && ($value < 0 || $value > 95.047)) {
            throw InvalidColorValue::xyzValueNotInRange($value, $name, 0, 95.047);
        }

        if ($name === 'y' && ($value < 0 || $value > 100)) {
            throw InvalidColorValue::xyzValueNotInRange($value, $name, 0, 100);
        }

        if ($name === 'z' && ($value < 0 || $value > 108.883)) {
            throw InvalidColorValue::xyzValueNotInRange($value, $name, 0, 108.883);
        }
    }

    public static function xyzColorString($string): void
    {
        if (! preg_match('/^ *xyz\( *\d{1,2}\.?\d+? *, *\d{1,3}\.?\d+? *, *\d{1,3}\.?\d+? *\) *$/i', $string)) {
            throw InvalidColorValue::malformedXyzColorString($string);
        }
    }
}
