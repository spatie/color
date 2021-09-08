<?php

namespace Spatie\Color;

interface Color
{
    public static function fromString(string $string);

    public function red();

    public function green();

    public function blue();

    public function toCIELab(): CIELab;

    public function toHex(string $alpha = 'ff'): Hex;

    public function toHsl(): Hsl;

    public function toHsla(float $alpha = 1): Hsla;

    public function toRgb(): Rgb;

    public function toRgba(float $alpha = 1): Rgba;

    public function toXyz(): Xyz;

    public function toCmyk(): Cmyk;

    public function __toString(): string;
}
