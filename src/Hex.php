<?php

namespace Spatie\Color;

class Hex
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

    public function toRgb(): Rgb
    {
        return new Rgb(
            Convert::hexValueToRgbValue($this->red),
            Convert::hexValueToRgbValue($this->green),
            Convert::hexValueToRgbValue($this->blue)
        );
    }

    public function toRgba(int $alpha = 100): Rgba
    {
        return $this->toRgb()->toRgba($alpha);
    }

    public function __toString()
    {
        return "#{$this->red}{$this->green}{$this->blue}";
    }
}
