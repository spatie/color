<?php

namespace Spatie\Color;

class Hsla implements Color
{
    public function __construct(
        protected float $hue,
        protected float $saturation,
        protected float $lightness,
        protected float $alpha = 1.0,
    ) {
        Validate::hslValue($saturation, 'saturation');
        Validate::hslValue($lightness, 'lightness');
        Validate::alphaChannelValue($alpha);
    }

    public static function fromString(string $string): static
    {
        Validate::hslaColorString($string);

        $matches = null;
        preg_match(HsPatterns::getExtractionPattern('hsla'), $string, $matches);

        return new static(
            (float) $matches[1],
            (float) $matches[2],
            (float) $matches[3],
            (float) $matches[4]
        );
    }

    public function hue(): float
    {
        return $this->hue;
    }

    public function saturation(): float
    {
        return $this->saturation;
    }

    public function lightness(): float
    {
        return $this->lightness;
    }

    public function red(): int
    {
        return Convert::hslValueToRgb($this->hue, $this->saturation, $this->lightness)[0];
    }

    public function green(): int
    {
        return Convert::hslValueToRgb($this->hue, $this->saturation, $this->lightness)[1];
    }

    public function blue(): int
    {
        return Convert::hslValueToRgb($this->hue, $this->saturation, $this->lightness)[2];
    }

    public function alpha(): float
    {
        return $this->alpha;
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

    public function toHsla(?float $alpha = null): self
    {
        return new self($this->hue(), $this->saturation(), $this->lightness(), $alpha ?? $this->alpha);
    }

    public function toHsl(): Hsl
    {
        return new Hsl($this->hue(), $this->saturation(), $this->lightness());
    }

    public function toRgb(): Rgb
    {
        return new Rgb($this->red(), $this->green(), $this->blue());
    }

    public function toArgb(?float $alpha = null): Argb
    {
        return $this->toRgb()->toArgb($alpha ?? $this->alpha);
    }

    public function toRgba(?float $alpha = null): Rgba
    {
        return new Rgba($this->red(), $this->green(), $this->blue(), $alpha ?? $this->alpha);
    }

    public function toXyz(): Xyz
    {
        return $this->toRgb()->toXyz();
    }

    public function __toString(): string
    {
        $hue = round($this->hue);
        $saturation = round($this->saturation);
        $lightness = round($this->lightness);
        $alpha = round($this->alpha, 2);

        return "hsla({$hue},{$saturation}%,{$lightness}%,{$alpha})";
    }
}
