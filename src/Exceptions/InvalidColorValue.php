<?php

namespace Spatie\Color\Exceptions;

use Exception;

class InvalidColorValue extends Exception
{
    public static function rgbChannelValueNotInRange(int $value, string $channel): self
    {
        return new static("An rgb values must be an integer between 0 and 255, `{$value}` provided for channel {$channel}.");
    }

    public static function alphaChannelValueNotInRange(int $value): self
    {
        return new static("An alpha values must be a float between 0 and 1, `{$value}` provided.");
    }

    public static function hexChannelValueHasInvalidLength(string $value): self
    {
        $length = strlen($value);

        return new static("Hex values must contain exactly 2 characters, `{$value}` contains {$length} characters.");
    }

    public static function hexValueContainsInvalidCharacters(string $value): self
    {
        return new static("Hex values can only contain numbers or letters from A-F, `{$value}` contains invalid characters.");
    }

    public static function malformedHexColorString(string $string): self
    {
        return new static("Hex color string `{$string}` is malformed. A hex color string starts with a `#` and contains exactly six characters, e.g. `#aabbcc`.");
    }

    public static function malformedRgbColorString(string $string): self
    {
        return new static("Rgb color string `{$string}` is malformed. An rgb color contains 3 comma separated values between 0 and 255, wrapped in `rgb()`, e.g. `rgb(0,0,255)`.");
    }

    public static function malformedRgbaColorString(string $string): self
    {
        return new static("Rgba color string `{$string}` is malformed. An rgba color contains 3 comma separated values between 0 and 255 with an alpha value between 0 and 1, wrapped in `rgba()`, e.g. `rgb(0,0,255,0.5)`.");
    }
}
