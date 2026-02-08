<?php

namespace Spatie\Color;

class CIELab implements Color
{
    public function __construct(
        protected float $l,
        protected float $a,
        protected float $b,
    ) {
        Validate::CIELabValue($l, 'l');
        Validate::CIELabValue($a, 'a');
        Validate::CIELabValue($b, 'b');
    }

    public static function fromString(string $string): static
    {
        Validate::CIELabColorString($string);

        $matches = null;
        preg_match('/CIELab\( *(\d{1,3}\.?\d* *, *-?\d{1,3}\.?\d* *, *-?\d{1,3}\.?\d*) *\)/i', $string, $matches);

        $channels = explode(',', $matches[1]);
        [$l, $a, $b] = array_map('trim', $channels);

        return new static((float) $l, (float) $a, (float) $b);
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

    public function toCIELab(): self
    {
        return new self($this->l, $this->a, $this->b);
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
        return $this->toXyz()->toRgb();
    }

    public function toArgb(?float $alpha = null): Argb
    {
        return $this->toRgb()->toArgb($alpha ?? 1.0);
    }

    public function toRgba(?float $alpha = null): Rgba
    {
        return $this->toRgb()->toRgba($alpha ?? 1.0);
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
