<?php

namespace Spatie\Color;

use Spatie\Color\Helpers\Convert;
use Spatie\Color\Helpers\Validate;

class Rgb
{
    /** @var int */
    protected $red, $green, $blue;

    public function __construct(int $red, int $green, int $blue)
    {
        Validate::rgbChannelValue($red, 'red');
        Validate::rgbChannelValue($green, 'green');
        Validate::rgbChannelValue($blue, 'blue');

        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
    }

    public static function fromString(string $string)
    {
        Validate::rgbColorString($string);

        $matches = null;
        preg_match('/rgb\((\d{1,3},\d{1,3},\d{1,3})\)/i', $string, $matches);

        list($red, $green, $blue) = explode(',', $matches[1]);

        return new static($red, $green, $blue);
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

    public function toRgba(int $alpha = 100): Rgba
    {
        return new Rgba($this->red, $this->green, $this->blue, $alpha);
    }

    public function toHex(): Hex
    {
        return new Hex(
            Convert::rgbValueToHexValue($this->red),
            Convert::rgbValueToHexValue($this->green),
            Convert::rgbValueToHexValue($this->blue)
        );
    }

    public function __toString()
    {
        return "rgb({$this->red},{$this->green},{$this->blue})";
    }
}
