<?php

namespace Spatie\Color;

class Hex implements Color
{
    /** @var string */
    protected $red, $green, $blue;

    public function __construct(string $red, string $green, string $blue)
    {
        Validate::hexChannelValue($red, 'red');
        Validate::hexChannelValue($green, 'green');
        Validate::hexChannelValue($blue, 'blue');

        $this->red = strtolower($red);
        $this->green = strtolower($green);
        $this->blue = strtolower($blue);
    }

    public static function fromString(string $string): Color
    {
        Validate::hexColorString($string);

        list($red, $green, $blue) = str_split(ltrim($string, '#'), 2);

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

    public function toHex(): self
    {
        return new self($this->red, $this->green, $this->blue);
    }

    public function toRgb(): Rgb
    {
        return new Rgb(
            Convert::hexChannelToRgbChannel($this->red),
            Convert::hexChannelToRgbChannel($this->green),
            Convert::hexChannelToRgbChannel($this->blue)
        );
    }

    public function toRgba(float $alpha = 1.0): Rgba
    {
        return $this->toRgb()->toRgba($alpha);
    }

    public function __toString(): string
    {
        return "#{$this->red}{$this->green}{$this->blue}";
    }
}
