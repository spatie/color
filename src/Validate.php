<?php

namespace Spatie\Color;

use Spatie\Color\Exceptions\InvalidColorValue;

class Validate
{
    public static function rgbChannelValue(int $value, string $channel)
    {
        if ($value < 0 || $value > 255) {
            throw InvalidColorValue::rgbChannelValueNotInRange($value, $channel);
        }
    }

    public static function alphaChannelValue(int $value)
    {
        if ($value < 0 || $value > 100) {
            throw InvalidColorValue::alphaChannelValueNotInRange($value);
        }
    }

    public static function hexChannelValue(string $value)
    {
        if (strlen($value) !== 2) {
            throw InvalidColorValue::hexChannelValueHasInvalidLength($value);
        }

        if (! preg_match('/[a-f0-9]{2}/i', $value)) {
            throw InvalidColorValue::hexValueContainsInvalidCharacters($value);
        }
    }

    public static function rgbColorString($string)
    {
        if (! preg_match('/rgb\(\d{1,3},\d{1,3},\d{1,3}\)/i', $string)) {
            throw InvalidColorValue::malformedRgbColorString($string);
        }
    }

    public static function rgbaColorString($string)
    {
        if (! preg_match('/rgba\(\d{1,3},\d{1,3},\d{1,3},[0-1](\.\d{1,2})?\)/i', $string)) {
            throw InvalidColorValue::malformedRgbaColorString($string);
        }
    }

    public static function hexColorString($string)
    {
        if (! preg_match('/#[a-f0-9]{6}/i', $string)) {
            throw InvalidColorValue::malformedHexColorString($string);
        }
    }
}
