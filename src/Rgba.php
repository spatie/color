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
        preg_match('/rgba\( *(\d{1,3} *, *\d{1,3} *, *\d{1,3} *, *[0-1]*(\.\d{1,})?) *\)/i', $string, $matches);

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

    public function toRgba(?float $alpha = null): self
    {
        return new self($this->red, $this->green, $this->blue, $alpha ?? $this->alpha);
    }

    public function toXyz(): Xyz
    {
        return $this->toRgb()->toXyz();
    }

    public function __toString(): string
    {
        $alpha = number_format($this->alpha, 2);

        return "rgba({$this->red},{$this->green},{$this->blue},{$alpha})";
    }
}
