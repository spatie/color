<?php

namespace Spatie\Color;

class Xyz implements Color
{
    /** @var float */
    protected $x;
    protected $y;
    protected $z;

    public function __construct(float $x, float $y, float $z)
    {
        Validate::xyzValue($x, 'x');
        Validate::xyzValue($y, 'y');
        Validate::xyzValue($z, 'z');

        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    public static function fromString(string $string)
    {
        Validate::xyzColorString($string);

        $matches = null;
        preg_match('/xyz\( *(\d{1,2}\.?\d+? *, *\d{1,3}\.?\d+? *, *\d{1,3}\.?\d+?) *\)/i', $string, $matches);

        $channels = explode(',', $matches[1]);
        [$x, $y, $z] = array_map('trim', $channels);

        return new static($x, $y, $z);
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
        $rgb = $this->toRgb();

        return $rgb->red();
    }

    public function blue(): int
    {
        $rgb = $this->toRgb();

        return $rgb->blue();
    }

    public function green(): int
    {
        $rgb = $this->toRgb();

        return $rgb->green();
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

    public function toHex(): Hex
    {
        return $this->toRgb()->toHex();
    }

    public function toHsl(): Hsl
    {
        return $this->toRgb()->toHSL();
    }

    public function toHsla(float $alpha = 1): Hsla
    {
        $hsl = $this->toHsl();

        return new Hsla($hsl->hue(), $hsl->saturation(), $hsl->lightness(), $alpha);
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

    public function toRgba(float $alpha = 1): Rgba
    {
        $rgb = $this->toRgb();

        return new Rgba($rgb->red(), $rgb->green(), $rgb->blue(), $alpha);
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
