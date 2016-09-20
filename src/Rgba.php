<?php

namespace Spatie\Color;

use Spatie\Color\Helpers\Validate;

class Rgba
{
    /** @var int */
    protected $red, $green, $blue, $alpha;

    public function __construct(int $red, int $green, int $blue, int $alpha)
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
        preg_match('/rgba\((\d{1,3},\d{1,3},\d{1,3},[0-1](\.\d{1,2})?)\)/i', $string, $matches);

        list($red, $green, $blue, $alpha) = explode(',', $matches[1]);
        $alpha = ((float) $alpha) * 100;

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

    public function alpha(): int
    {
        return $this->alpha;
    }

    public function toRgb(): Rgb
    {
        return new Rgb($this->red, $this->green, $this->blue);
    }

    public function toHex(): Hex
    {
        return $this->toRgb()->toHex();
    }

    public function __toString()
    {
        $alpha = number_format($this->alpha / 100, 2);

        return "rgba({$this->red},{$this->green},{$this->blue},{$alpha})";
    }
}
