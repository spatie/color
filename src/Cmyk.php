<?php

namespace Spatie\Color;

class Cmyk implements Color
{
    /** @var float */
    protected $cyan;
    protected $magenta;
    protected $yellow;
    protected $key;

    public function __construct(float $cyan, float $magenta, float $yellow, float $key)
    {
        Validate::cmykValue($cyan, 'cyan');
        Validate::cmykValue($magenta, 'magenta');
        Validate::cmykValue($yellow, 'yellow');
        Validate::cmykValue($key, 'key (black)');

        $this->cyan = $cyan;
        $this->magenta = $magenta;
        $this->yellow = $yellow;
        $this->key = $key;
    }

    public static function fromString(string $string)
    {
        Validate::cmykColorString($string);

        $matches = null;
        preg_match('/cmyk\( *(\d{1,3})%? *, *(\d{1,3})%? *, *(\d{1,3})%? *, *(\d{1,3})%? *\)/i', $string, $matches);

        return new static($matches[1] / 100, $matches[2] / 100, $matches[3] / 100, $matches[4] / 100);
    }

    public function red(): int
    {
        return Convert::cmykValueToRgb($this->cyan, $this->magenta, $this->yellow, $this->key)[0];
    }

    public function green(): int
    {
        return Convert::cmykValueToRgb($this->cyan, $this->magenta, $this->yellow, $this->key)[1];
    }

    public function blue(): int
    {
        return Convert::cmykValueToRgb($this->cyan, $this->magenta, $this->yellow, $this->key)[2];
    }

    public function cyan(): float
    {
        return $this->cyan;
    }

    public function magenta(): float
    {
        return $this->magenta;
    }

    public function yellow(): float
    {
        return $this->yellow;
    }

    public function key(): float
    {
        return $this->key;
    }

    public function black(): float
    {
        return $this->key;
    }

    public function toCmyk(): Cmyk
    {
        return new self($this->cyan, $this->magenta, $this->yellow, $this->key);
    }

    public function toCIELab(): CIELab
    {
        return $this->toRgb()->toCIELab();
    }

    public function toHex(string $alpha = 'ff'): Hex
    {
        return $this->toRgb()->toHex($alpha);
    }

    public function toHsl(): Hsl
    {
        return $this->toRgb()->toHsl();
    }

    public function toHsla(float $alpha = 1): Hsla
    {
        return $this->toRgb()->toHsla($alpha);
    }

    public function toRgb(): Rgb
    {
        list($red, $green, $blue) = Convert::cmykValueToRgb($this->cyan, $this->magenta, $this->yellow, $this->key);
        return new Rgb($red, $green, $blue);
    }

    public function toRgba(float $alpha = 1): Rgba
    {
        return $this->toRgb()->toRgba($alpha);
    }

    public function toXyz(): Xyz
    {
        return $this->toRgba()->toXyz();
    }

    public function __toString(): string
    {
        $cyan = round($this->cyan * 100);
        $magenta = round($this->magenta * 100);
        $yellow = round($this->yellow * 100);
        $key = round($this->key * 100);

        return "cmyk({$cyan}%,{$magenta}%,{$yellow}%,{$key}%)";
    }
}
