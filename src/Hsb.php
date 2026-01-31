<?php

namespace Spatie\Color;

class Hsb implements Color
{
    public function __construct(
        protected float $hue,
        protected float $saturation,
        protected float $brightness,
    ) {
        Validate::hsbValue($hue, 'hue');
        Validate::hsbValue($saturation, 'saturation');
        Validate::hsbValue($brightness, 'brightness');
    }

    public static function fromString(string $string): static
    {
        Validate::hsbColorString($string);

        $matches = null;
        preg_match(HsPatterns::getExtractionPattern('hsb'), $string, $matches);

        return new static(
            (float) $matches[1],
            (float) $matches[2],
            (float) $matches[3],
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

    public function brightness(): float
    {
        return $this->brightness;
    }

    public function red(): int
    {
        return Convert::hsbValueToRgb($this->hue, $this->saturation, $this->brightness)[0];
    }

    public function green(): int
    {
        return Convert::hsbValueToRgb($this->hue, $this->saturation, $this->brightness)[1];
    }

    public function blue(): int
    {
        return Convert::hsbValueToRgb($this->hue, $this->saturation, $this->brightness)[2];
    }

    public function toCIELab(): CIELab
    {
        return $this->toRgb()->toCIELab();
    }

    public function toCmyk(): Cmyk
    {
        return $this->toRgb()->toCmyk();
    }

    public function toHsb(): self
    {
        return new self($this->hue, $this->saturation, $this->brightness);
    }

    public function toHex(?string $alpha = null): Hex
    {
        return $this->toRgb()->toHex($alpha ?? 'ff');
    }

    public function toHsl(): Hsl
    {
        return $this->toRgb()->toHsl();
    }

    public function toHsla(?float $alpha = null): Hsla
    {
        return $this->toRgb()->toHsla($alpha ?? 1.0);
    }

    public function toRgb(): Rgb
    {
        return new Rgb($this->red(), $this->green(), $this->blue());
    }

    public function toRgba(?float $alpha = null): Rgba
    {
        return new Rgba($this->red(), $this->green(), $this->blue(), $alpha ?? 1.0);
    }

    public function toXyz(): Xyz
    {
        return $this->toRgb()->toXyz();
    }

    public function __toString(): string
    {
        $hue = round($this->hue);
        $saturation = round($this->saturation);
        $brightness = round($this->brightness);

        return "hsb({$hue},{$saturation}%,{$brightness}%)";
    }
}
