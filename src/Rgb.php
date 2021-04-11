<?php

namespace Spatie\Color;

class Rgb implements Color
{
    /** @var int */
    protected $red;
    protected $green;
    protected $blue;

    public function __construct(int $red, int $green, int $blue)
    {
        Validate::rgbChannelValue($red, 'red');
        Validate::rgbChannelValue($green, 'green');
        Validate::rgbChannelValue($blue, 'blue');

        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
    }

    public static function fromString(string $string)
    {
        Validate::rgbColorString($string);

        $matches = null;
        preg_match('/rgb\( *(\d{1,3} *, *\d{1,3} *, *\d{1,3}) *\)/i', $string, $matches);

        $channels = explode(',', $matches[1]);
        [$red, $green, $blue] = array_map('trim', $channels);

        return new static($red, $green, $blue);
    }

    public function red(): int
    {
        return $this->red;
    }

    public function green(): int
    {
        return $this->green;
    }

    public function blue(): int
    {
        return $this->blue;
    }

    public function mix($mixColor, $weight = 0.5): self
    {
        $f = function ($x) use ($weight) {
            return $weight * $x;
        };

        $g = function ($x) use ($weight) {
            return (1 - $weight) * $x;
        };

        $h = function ($x, $y) {
            return round($x + $y);
        };

        return new self(
            array_map(
                $h,
                array_map($f, [$this->red, $this->green, $this->blue]),
                array_map($g, [$mixColor->red, $mixColor->green, $mixColor->blue])
            )
        );
    }

    public function toHex(): Hex
    {
        return new Hex(
            Convert::rgbChannelToHexChannel($this->red),
            Convert::rgbChannelToHexChannel($this->green),
            Convert::rgbChannelToHexChannel($this->blue)
        );
    }

    public function toHsl(): Hsl
    {
        [$hue, $saturation, $lightness] = Convert::rgbValueToHsl(
            $this->red,
            $this->green,
            $this->blue
        );

        return new Hsl($hue, $saturation, $lightness);
    }

    public function toHsla(float $alpha = 1): Hsla
    {
        [$hue, $saturation, $lightness] = Convert::rgbValueToHsl(
            $this->red,
            $this->green,
            $this->blue
        );

        return new Hsla($hue, $saturation, $lightness, $alpha);
    }

    public function toRgb(): self
    {
        return new self($this->red, $this->green, $this->blue);
    }

    public function toRgba(float $alpha = 1): Rgba
    {
        return new Rgba($this->red, $this->green, $this->blue, $alpha);
    }

    public function toLuminanceScale(
        array $scale = [
            50 => 93.0,
            100 => 86.0,
            200 => 74.0,
            300 => 59.0,
            400 => 39.0,
            500 => 24.0,
            600 => 15.0,
            700 => 11.5,
            800 => 7.0,
            900 => 3.0,
        ]
    ): array {
        $palette = [];
        $hsl = $this->toHsl();
        foreach ($scale as $key => $luminance) {
            [$hue, $saturation, $lightness] = Convert::hslValueFromLuminance(
                $hsl->hue(),
                $hsl->saturation(),
                $luminance
            );
            $newHsl = new Hsl($hue, $saturation, $lightness);
            $palette[$key] = $newHsl->toRgb();
        }

        return $palette;
    }

    public function __toString(): string
    {
        return "rgb({$this->red},{$this->green},{$this->blue})";
    }
}
