<?php

namespace Spatie\Color;

interface Color
{
    public static function fromString(string $string);
    
    public function red();

    public function green();

    public function blue();

    public function toHex(): Hex;

    public function toRgb(): Rgb;

    public function toRgba(float $alpha = 1): Rgba;

    public function __toString(): string;
}
