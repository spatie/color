<?php

namespace Spatie\Color;

class Argb implements Color
{
    public function __construct(
        protected float $alpha,
        protected int $red,
        protected int $green,
        protected int $blue,
    ) {
        Validate::alphaChannelValue($alpha);
        Validate::rgbChannelValue($red, 'red');
        Validate::rgbChannelValue($green, 'green');
        Validate::rgbChannelValue($blue, 'blue');
    }

    public static function fromString(string $string): static
    {
        Validate::argbColorString($string);

        $matches = null;
        preg_match('/argb\( *([0-1]*(\.\d{1,})? *, *\d{1,3} *, *\d{1,3} *, *\d{1,3}) *\)/i', $string, $matches);

        $channels = explode(',', $matches[1]);
        [$alpha, $red, $green, $blue] = array_map('trim', $channels);

        return new static((float) $alpha, (int) $red, (int) $green, (int) $blue);
    }

    public function alpha(): float
    {
        return $this->alpha;
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

    public function toCIELab(): CIELab
    {
        return $this->toRgb()->toCIELab();
    }

    public function toCmyk(): Cmyk
    {
        return $this->toRgb()->toCmyk();
    }

    public function toHex(?string $alpha = null): Hex
    {
        return $this->toRgb()->toHex($alpha ?? Convert::floatAlphaToHex($this->alpha));
    }

    public function toHsb(): Hsb
    {
        return $this->toRgb()->toHsb();
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

    public function toHsla(?float $alpha = null): Hsla
    {
        return $this->toRgb()->toHsla($alpha ?? $this->alpha);
    }

    public function toRgb(): Rgb
    {
        return new Rgb($this->red, $this->green, $this->blue);
    }

    public function toRgba(?float $alpha = null): Rgba
    {
        return new Rgba($this->red, $this->green, $this->blue, $alpha ?? $this->alpha);
    }

    public function toArgb(?float $alpha = null): self
    {
        return new self($alpha ?? $this->alpha, $this->red, $this->green, $this->blue);
    }

    public function toXyz(): Xyz
    {
        return $this->toRgb()->toXyz();
    }

    public function __toString(): string
    {
        $alpha = number_format($this->alpha, 2);

        return "argb({$alpha},{$this->red},{$this->green},{$this->blue})";
    }
}
