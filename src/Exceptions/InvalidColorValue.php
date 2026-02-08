<?php

namespace Spatie\Color\Exceptions;

use Exception;

class InvalidColorValue extends Exception
{
    public static function CIELabValueNotInRange(float $value, string $name, float $min, float $max): self
    {
        return new self("CIELab value `{$name}` must be a number between {$min} and {$max}");
    }

    public static function rgbChannelValueNotInRange(int $value, string $channel): self
    {
        return new self("An rgb values must be an integer between 0 and 255, `{$value}` provided for channel {$channel}.");
    }

    public static function alphaChannelValueNotInRange(float $value): self
    {
        return new self("An alpha values must be a float between 0 and 1, `{$value}` provided.");
    }

    public static function hexChannelValueHasInvalidLength(string $value): self
    {
        $length = strlen($value);

        return new self("Hex values must contain exactly 2 characters, `{$value}` contains {$length} characters.");
    }

    public static function malformedCIELabColorString(string $string): self
    {
        return new self("CIELab color string `{$string}` is malformed. A CIELab color contains 3 comma separated values, wrapped in `CIELab()`, e.g. `CIELab(62.91,5.34,-57.73)`.");
    }

    public static function cmykValueNotInRange(float $value, string $name): self
    {
        return new self("Cmyk value `{$name}` must be a number between 0 and 1");
    }

    public static function hexValueContainsInvalidCharacters(string $value): self
    {
        return new self("Hex values can only contain numbers or letters from A-F, `{$value}` contains invalid characters.");
    }

    public static function hsbValueNotInRange(float $value, string $name): self
    {
        return new self("Hsb value `{$name}` must be a number between 0 and 100");
    }

    public static function hslValueNotInRange(float $value, string $name): self
    {
        return new self("Hsl value `{$name}` must be a number between 0 and 100");
    }

    public static function malformedCmykColorString(string $string): self
    {
        return new self("Cmyk color string `{$string}` is malformed. A cmyk color contains cyan, magenta, yellow and key (black) values, wrapped in `cmyk()`, e.g. `cmyk(100%,100%,100%,100%)`.");
    }

    public static function malformedHexColorString(string $string): self
    {
        return new self("Hex color string `{$string}` is malformed. A hex color string starts with a `#` and contains exactly six characters, e.g. `#aabbcc`.");
    }

    public static function malformedHslColorString(string $string): self
    {
        return new self("Hsl color string `{$string}` is malformed. An hsl color contains hue, saturation, and lightness values, wrapped in `hsl()`, e.g. `hsl(300,10%,50%)`.");
    }

    public static function malformedHslaColorString(string $string): self
    {
        return new self("Hsla color string `{$string}` is malformed. An hsla color contains hue, saturation, lightness and alpha values, wrapped in `hsla()`, e.g. `hsla(300,10%,50%,0.25)`.");
    }

    public static function malformedRgbColorString(string $string): self
    {
        return new self("Rgb color string `{$string}` is malformed. An rgb color contains 3 comma separated values between 0 and 255, wrapped in `rgb()`, e.g. `rgb(0,0,255)`.");
    }

    public static function malformedRgbaColorString(string $string): self
    {
        return new self("Rgba color string `{$string}` is malformed. An rgba color contains 3 comma separated values between 0 and 255 with an alpha value between 0 and 1, wrapped in `rgba()`, e.g. `rgb(0,0,255,0.5)`.");
    }

    public static function malformedArgbColorString(string $string): self
    {
        return new self("Argb color string `{$string}` is malformed. An argb color contains an alpha value between 0 and 1 followed by 3 comma separated values between 0 and 255, wrapped in `argb()`, e.g. `argb(0.5,0,0,255)`.");
    }

    public static function malformedColorString(string $string): self
    {
        return new self("Color string `{$string}` doesn't match any of the available colors.");
    }

    public static function malformedXyzColorString(string $string): self
    {
        return new self("Xyz color string `{$string}` is malformed. An xyz color contains 3 comma separated values, wrapped in `xyz()`, e.g. `xyz(31.3469,31.4749,99.0308)`.");
    }

    public static function xyzValueNotInRange(float $value, string $name, float $min, float $max): self
    {
        return new self("Xyz value `{$name}` must be a number between {$min} and {$max}");
    }

    public static function malformedNamedColorString(string $string): self
    {
        return new self("Color string `{$string}` doesn't match any of the available colors.");
    }
}
