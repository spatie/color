<?php

namespace Spatie\Color;

class Rgba implements Color
{
    /** @var int */
    protected $red;
    protected $green;
    protected $blue;

    /** @var float */
    protected $alpha;

    public function __construct(int $red, int $green, int $blue, float $alpha)
    {
        Validate::rgbChannelValue($red, 'red');
        Validate::rgbChannelValue($green, 'green');
        Validate::rgbChannelValue($blue, 'blue');
        Validate::alphaChannelValue($alpha);

        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
        $this->alpha = $alpha;
    }

    public static function fromString(string $string)
    {
        Validate::rgbaColorString($string);

        $matches = null;
        preg_match('/rgba\( *(\d{1,3} *, *\d{1,3} *, *\d{1,3} *, *[0-1](\.\d{1,2})?) *\)/i', $string, $matches);

        $channels = explode(',', $matches[1]);
        [$red, $green, $blue, $alpha] = array_map('trim', $channels);

        return new static($red, $green, $blue, $alpha);
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

    public function alpha(): float
    {
        return $this->alpha;
    }

    public function toHex(): Hex
    {
        return $this->toRgb()->toHex();
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

    public function toRgb(): Rgb
    {
        return new Rgb($this->red, $this->green, $this->blue);
    }

    public function toRgba(float $alpha = 1): self
    {
        return new self($this->red, $this->green, $this->blue, $alpha);
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
            $palette[$colorName] = $wheelColor->toRgba();
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
        $alpha = number_format($this->alpha, 2);

        return "rgba({$this->red},{$this->green},{$this->blue},{$alpha})";
    }
}
