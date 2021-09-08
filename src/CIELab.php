<?php

namespace Spatie\Color;

class CIELab implements Color
{
    /** @var float */
    protected $l;
    protected $a;
    protected $b;

    public function __construct(float $l, float $a, float $b)
    {
        Validate::CIELabValue($l, 'l');
        Validate::CIELabValue($a, 'a');
        Validate::CIELabValue($b, 'b');

        $this->l = $l;
        $this->a = $a;
        $this->b = $b;
    }

    public static function fromString(string $string)
    {
        Validate::CIELabColorString($string);

        $matches = null;
        preg_match('/CIELab\( *(\d{1,3}\.?\d+? *, *-?\d{1,3}\.?\d+? *, *-?\d{1,3}\.?\d+?) *\)/i', $string, $matches);

        $channels = explode(',', $matches[1]);
        [$l, $a, $b] = array_map('trim', $channels);

        return new static($l, $a, $b);
    }

    public function l(): float
    {
        return $this->l;
    }

    public function a(): float
    {
        return $this->a;
    }

    public function b(): float
    {
        return $this->b;
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

    public function toCIELab(): self
    {
        return new self($this->l, $this->a, $this->b);
    }

    public function toCmyk(): Cmyk
    {
        return $this->toRgb()->toCmyk();
    }

    public function toHex(string $alpha = 'ff'): Hex
    {
        return $this->toRgb()->toHex($alpha);
    }

    public function toHsb(): Hsb
    {
        return $this->toRgb()->toHsb();
    }

    public function toHsl(): Hsl
    {
        return $this->toRgb()->toHSL();
    }

    public function toHsla(float $alpha = 1): Hsla
    {
        return $this->toRgb()->toHsla($alpha);
    }

    public function toRgb(): Rgb
    {
        return $this->toXyz()->toRgb();
    }

    public function toRgba(float $alpha = 1): Rgba
    {
        return $this->toRgb()->toRgba($alpha);
    }

    public function toXyz(): Xyz
    {
        [$x, $y, $z] = Convert::CIELabValueToXyz(
            $this->l,
            $this->a,
            $this->b
        );

        return new Xyz($x, $y, $z);
    }

    public function __toString(): string
    {
        return "CIELab({$this->l},{$this->a},{$this->b})";
    }
}
