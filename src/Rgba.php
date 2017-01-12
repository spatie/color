<?php

namespace Spatie\Color;

class Rgba
{
    /** @var int */
    protected $red, $green, $blue;

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
        preg_match('/rgba\( *(\d{1,3} *, *\d{1,3} *, *\d{1,3} *, *[0-1](\.\d{1,2})?) *\)/i', $string, $matches);

        $channels = explode(',', $matches[1]);
        list($red, $green, $blue, $alpha) = array_map('trim', $channels);

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
        $alpha = number_format($this->alpha, 2);

        return "rgba({$this->red},{$this->green},{$this->blue},{$alpha})";
    }
}
