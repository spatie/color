<?php

namespace Spatie\Color;

class Hex implements Color
{
    /** @var string */
    protected $red;
    protected $green;
    protected $blue;
    protected $alpha = 'ff';

    public function __construct(string $red, string $green, string $blue, string $alpha = 'ff')
    {
        Validate::hexChannelValue($red, 'red');
        Validate::hexChannelValue($green, 'green');
        Validate::hexChannelValue($blue, 'blue');
        Validate::hexChannelValue($alpha, 'alpha');

        $this->red = strtolower($red);
        $this->green = strtolower($green);
        $this->blue = strtolower($blue);
        $this->alpha = strtolower($alpha);
    }

    public static function fromString(string $string)
    {
        Validate::hexColorString($string);

        $string = ltrim($string, '#');

        switch (strlen($string)) {
            case 3:
                [$red, $green, $blue] = str_split($string);
                $red .= $red;
                $green .= $green;
                $blue .= $blue;
                $alpha = 'ff';

                break;

            case 4:
                [$red, $green, $blue, $alpha] = str_split($string);
                $red .= $red;
                $green .= $green;
                $blue .= $blue;
                $alpha .= $alpha;

                break;

            default:
            case 6:
                [$red, $green, $blue] = str_split($string, 2);
                $alpha = 'ff';

                break;

            case 8:
                [$red, $green, $blue, $alpha] = str_split($string, 2);

                break;
        }

        return new static($red, $green, $blue, $alpha);
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

    public function alpha(): string
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

    public function toHex(string $alpha = 'ff'): self
    {
        return new self($this->red, $this->green, $this->blue, $alpha);
    }

    public function toHsb(): Hsb
    {
        return $this->toRgb()->toHsb();
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
        return "#{$this->red}{$this->green}{$this->blue}" . ($this->alpha !== 'ff' ? $this->alpha : '');
    }
}
