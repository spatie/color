<?php

namespace Spatie\Color;

interface Color
{
    public static function fromString(string $string);

    public function red();

    public function green();

    public function blue();

    public function toHex(): Hex;

    public function toHsl(): Hsl;

    public function toHsla(float $alpha = 1): Hsla;

    public function toRgb(): Rgb;

    public function toRgba(float $alpha = 1): Rgba;

    public function toLuminanceScale(
        array $scale = [
            50 => 93.0,
            100 => 86.0,
            200 => 74.0,
            300 => 59.0,
            400 => 39.0,
            500 => 24.0,
            600 => 15.0,
            700 => 11.5,
            800 => 7.0,
            900 => 3.0,
        ]
    ): array;

    public function __toString(): string;
}
