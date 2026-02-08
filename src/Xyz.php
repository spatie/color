<?php

namespace Spatie\Color;

class Xyz implements Color
{
    public function __construct(
        protected float $x,
        protected float $y,
        protected float $z,
    ) {
        Validate::xyzValue($x, 'x');
        Validate::xyzValue($y, 'y');
        Validate::xyzValue($z, 'z');
    }

    public static function fromString(string $string): static
    {
        Validate::xyzColorString($string);

        $matches = null;
        preg_match('/xyz\( *(\d{1,2}\.?\d+? *, *\d{1,3}\.?\d+? *, *\d{1,3}\.?\d+?) *\)/i', $string, $matches);

        $channels = explode(',', $matches[1]);
        [$x, $y, $z] = array_map('trim', $channels);

        return new static((float) $x, (float) $y, (float) $z);
    }

    public function x(): float
    {
        return $this->x;
    }

    public function y(): float
    {
        return $this->y;
    }

    public function z(): float
    {
        return $this->z;
    }

    public function red(): int
    {
        return $this->toRgb()->red();
    }

    public function blue(): int
    {
        return $this->toRgb()->blue();
    }

    public function green(): int
    {
        return $this->toRgb()->green();
    }

    public function toCIELab(): CIELab
    {
        [$l, $a, $b] = Convert::xyzValueToCIELab(
            $this->x,
            $this->y,
            $this->z
        );

        return new CIELab($l, $a, $b);
    }

    public function toCmyk(): Cmyk
    {
        return $this->toRgb()->toCmyk();
    }

    public function toHex(?string $alpha = null): Hex
    {
        return $this->toRgb()->toHex($alpha ?? 'ff');
    }

    public function toHsb(): Hsb
    {
        return $this->toRgb()->toHsb();
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
        [$red, $green, $blue] = Convert::xyzValueToRgb(
            $this->x,
            $this->y,
            $this->z
        );

        return new Rgb($red, $green, $blue);
    }

    public function toArgb(?float $alpha = null): Argb
    {
        return $this->toRgb()->toArgb($alpha ?? 1.0);
    }

    public function toRgba(?float $alpha = null): Rgba
    {
        return $this->toRgb()->toRgba($alpha ?? 1.0);
    }

    public function toXyz(): self
    {
        return new self($this->x, $this->y, $this->z);
    }

    public function __toString(): string
    {
        return "xyz({$this->x},{$this->y},{$this->z})";
    }
}
