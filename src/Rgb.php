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

    public function toColorWheel()
    {
        $palette = [];
        $hsl = $this->toHsl();
        for ($deg = 0; $deg < 360; $deg += 30) {
            $newHue = $hsl->hue() + $deg;
            if ($newHue > 360) {
                $newHue -= 360;
            }
            $colorName = Convert::hueToColorName($newHue);
            $wheelColor = new Hsl($newHue, $hsl->saturation(), $hsl->lightness());
            $palette[$colorName] = $wheelColor->toRgb();
        }

        return $palette;
    }

    public function toColorName()
    {
        $hsl = $this->toHsl();
        return Convert::hueToColorName($hsl->hue());
    }

    public function __toString(): string
    {
        return "rgb({$this->red},{$this->green},{$this->blue})";
    }
}
