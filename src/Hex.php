<?php

namespace Spatie\Color;

class Hex implements Color
{
    /** @var string */
    protected $red;
    protected $green;
    protected $blue;

    public function __construct(string $red, string $green, string $blue)
    {
        Validate::hexChannelValue($red, 'red');
        Validate::hexChannelValue($green, 'green');
        Validate::hexChannelValue($blue, 'blue');

        $this->red = strtolower($red);
        $this->green = strtolower($green);
        $this->blue = strtolower($blue);
    }

    public static function fromString(string $string)
    {
        Validate::hexColorString($string);

        [$red, $green, $blue] = str_split(ltrim($string, '#'), 2);

        return new static($red, $green, $blue);
    }

    public function red(): string
    {
        return $this->red;
    }

    public function green(): string
    {
        return $this->green;
    }

    public function blue(): string
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

    public function toHex(): self
    {
        return new self($this->red, $this->green, $this->blue);
    }

    public function toHsl(): Hsl
    {
        [$hue, $saturation, $lightness] = Convert::rgbValueToHsl(
            Convert::hexChannelToRgbChannel($this->red),
            Convert::hexChannelToRgbChannel($this->green),
            Convert::hexChannelToRgbChannel($this->blue)
        );

        return new Hsl($hue, $saturation, $lightness);
    }

    public function toHsla(float $alpha = 1): Hsla
    {
        [$hue, $saturation, $lightness] = Convert::rgbValueToHsl(
            Convert::hexChannelToRgbChannel($this->red),
            Convert::hexChannelToRgbChannel($this->green),
            Convert::hexChannelToRgbChannel($this->blue)
        );

        return new Hsla($hue, $saturation, $lightness, $alpha);
    }

    public function toRgb(): Rgb
    {
        return new Rgb(
            Convert::hexChannelToRgbChannel($this->red),
            Convert::hexChannelToRgbChannel($this->green),
            Convert::hexChannelToRgbChannel($this->blue)
        );
    }

    public function toRgba(float $alpha = 1): Rgba
    {
        return $this->toRgb()->toRgba($alpha);
    }

    public function toXyz(): Xyz
    {
        return $this->toRgb()->toXyz();
    }

    public function __toString(): string
    {
        return "#{$this->red}{$this->green}{$this->blue}";
    }
}
