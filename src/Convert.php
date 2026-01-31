<?php

namespace Spatie\Color;

final class Convert
{
    /** @return array{float, float, float} */
    public static function CIELabValueToXyz(float $l, float $a, float $b): array
    {
        $y = ($l + 16) / 116;
        $x = $a / 500 + $y;
        $z = $y - $b / 200;

        $x = pow($x, 3) > 0.008856 ? pow($x, 3) : ($x - 16 / 116) / 7.787;
        $y = pow($y, 3) > 0.008856 ? pow($y, 3) : ($y - 16 / 116) / 7.787;
        $z = pow($z, 3) > 0.008856 ? pow($z, 3) : ($z - 16 / 116) / 7.787;

        $x = min(round(95.047 * $x, 4), 95.047);
        $y = min(round(100.000 * $y, 4), 100);
        $z = min(round(108.883 * $z, 4), 108.883);

        return [$x, $y, $z];
    }

    /** @return array{int, int, int} */
    public static function cmykValueToRgb(float $cyan, float $magenta, float $yellow, float $key): array
    {
        return [
            (int) (255 * (1 - $cyan) * (1 - $key)),
            (int) (255 * (1 - $magenta) * (1 - $key)),
            (int) (255 * (1 - $yellow) * (1 - $key)),
        ];
    }

    /** @return array{float, float, float, float} */
    public static function rgbValueToCmyk(int $red, int $green, int $blue): array
    {
        $red /= 255;
        $green /= 255;
        $blue /= 255;

        $black = 1 - max($red, $green, $blue);
        $keyNeg = (1 - $black);

        return [
            (1 - $red - $black) / ($keyNeg ?: 1),
            (1 - $green - $black) / ($keyNeg ?: 1),
            (1 - $blue - $black) / ($keyNeg ?: 1),
            $black,
        ];
    }

    public static function hexChannelToRgbChannel(string $hexValue): int
    {
        return hexdec($hexValue);
    }

    public static function rgbChannelToHexChannel(int $rgbValue): string
    {
        return str_pad(dechex($rgbValue), 2, '0', STR_PAD_LEFT);
    }

    public static function hexAlphaToFloat(string $hexAlpha): float
    {
        return round(self::hexChannelToRgbChannel($hexAlpha) / 255, 2);
    }

    public static function floatAlphaToHex(float $floatAlpha): string
    {
        return self::rgbChannelToHexChannel((int) round($floatAlpha * 255, 0));
    }

    /** @return array{int, int, int} */
    public static function hsbValueToRgb(float $hue, float $saturation, float $brightness): array
    {
        while ($hue > 360) {
            $hue -= 360.0;
        }
        while ($hue < 0) {
            $hue += 360.0;
        }

        $hue /= 360;
        $saturation /= 100;
        $brightness /= 100;

        if ($saturation == 0) {
            $R = $G = $B = $brightness * 255;
        } else {
            $hue = $hue * 6;
            $i = floor($hue);
            $j = $brightness * (1 - $saturation);
            $k = $brightness * (1 - $saturation * ($hue - $i));
            $l = $brightness * (1 - $saturation * (1 - ($hue - $i)));

            [$red, $green, $blue] = match ((int) $i) {
                0 => [$brightness, $l, $j],
                1 => [$k, $brightness, $j],
                2 => [$j, $brightness, $l],
                3 => [$j, $k, $brightness],
                4 => [$l, $j, $brightness],
                default => [$brightness, $j, $k],
            };

            $R = $red * 255;
            $G = $green * 255;
            $B = $blue * 255;
        }

        return [(int) round($R), (int) round($G), (int) round($B)];
    }

    /** @return array{int, int, int} */
    public static function hslValueToRgb(float $hue, float $saturation, float $lightness): array
    {
        $h = (int) ((360 + ((int) $hue % 360)) % 360);

        $c = (1 - abs(2 * ($lightness / 100) - 1)) * ($saturation / 100);
        $x = $c * (1 - abs(fmod($h / 60, 2) - 1));
        $m = ($lightness / 100) - ($c / 2);

        [$r, $g, $b] = match (true) {
            $h >= 0 && $h <= 60 => [$c + $m, $x + $m, $m],
            $h > 60 && $h <= 120 => [$x + $m, $c + $m, $m],
            $h > 120 && $h <= 180 => [$m, $c + $m, $x + $m],
            $h > 180 && $h <= 240 => [$m, $x + $m, $c + $m],
            $h > 240 && $h <= 300 => [$x + $m, $m, $c + $m],
            default => [$c + $m, $m, $x + $m],
        };

        return [(int) round($r * 255), (int) round($g * 255), (int) round($b * 255)];
    }

    /** @return array{float, float, float} */
    public static function rgbValueToHsb(int $red, int $green, int $blue): array
    {
        $red /= 255;
        $green /= 255;
        $blue /= 255;

        $min = min($red, $green, $blue);
        $max = max($red, $green, $blue);
        $delMax = $max - $min;

        $brightness = $max;
        $hue = 0.0;

        if ($delMax == 0) {
            $saturation = 0.0;
        } else {
            $saturation = $delMax / $max;

            $delR = ((($max - $red) / 6) + ($delMax / 2)) / $delMax;
            $delG = ((($max - $green) / 6) + ($delMax / 2)) / $delMax;
            $delB = ((($max - $blue) / 6) + ($delMax / 2)) / $delMax;

            if ($red == $max) {
                $hue = $delB - $delG;
            } elseif ($green == $max) {
                $hue = (1 / 3) + $delR - $delB;
            } elseif ($blue == $max) {
                $hue = (2 / 3) + $delG - $delR;
            }

            if ($hue < 0) {
                $hue++;
            }
            if ($hue > 1) {
                $hue--;
            }
        }

        return [round($hue, 2) * 360, round($saturation, 2) * 100, round($brightness, 2) * 100];
    }

    /** @return array{float, float, float} */
    public static function rgbValueToHsl(int $red, int $green, int $blue): array
    {
        $r = $red / 255;
        $g = $green / 255;
        $b = $blue / 255;

        $cmax = max($r, $g, $b);
        $cmin = min($r, $g, $b);
        $delta = $cmax - $cmin;

        $hue = 0.0;
        if ($delta != 0) {
            if ($r === $cmax) {
                $hue = 60 * fmod(($g - $b) / $delta, 6);
                $hue = $hue < 0 ? $hue + 360 : $hue;
            }

            if ($g === $cmax) {
                $hue = 60 * ((($b - $r) / $delta) + 2);
            }

            if ($b === $cmax) {
                $hue = 60 * ((($r - $g) / $delta) + 4);
            }
        }

        $lightness = ($cmax + $cmin) / 2;

        $saturation = 0.0;

        if ($lightness > 0 && $lightness < 1) {
            $saturation = $delta / (1 - abs((2 * $lightness) - 1));
        }

        return [$hue, min($saturation, 1) * 100, min($lightness, 1) * 100];
    }

    /** @return array{float, float, float} */
    public static function rgbValueToXyz(int $red, int $green, int $blue): array
    {
        $red = $red / 255;
        $green = $green / 255;
        $blue = $blue / 255;

        $red = $red > 0.04045 ? pow((($red + 0.055) / 1.055), 2.4) : $red / 12.92;
        $green = $green > 0.04045 ? pow((($green + 0.055) / 1.055), 2.4) : $green / 12.92;
        $blue = $blue > 0.04045 ? pow((($blue + 0.055) / 1.055), 2.4) : $blue / 12.92;

        $red *= 100;
        $green *= 100;
        $blue *= 100;

        $x = min(round($red * 0.4124 + $green * 0.3576 + $blue * 0.1805, 4), 95.047);
        $y = min(round($red * 0.2126 + $green * 0.7152 + $blue * 0.0722, 4), 100);
        $z = min(round($red * 0.0193 + $green * 0.1192 + $blue * 0.9505, 4), 108.883);

        return [$x, $y, $z];
    }

    /** @return array{float, float, float} */
    public static function xyzValueToCIELab(float $x, float $y, float $z): array
    {
        $x = $x / 95.047;
        $y = $y / 100.000;
        $z = $z / 108.883;

        $x = $x > 0.008856 ? pow($x, 1 / 3) : (7.787 * $x) + (16 / 116);
        $y = $y > 0.008856 ? pow($y, 1 / 3) : (7.787 * $y) + (16 / 116);

        $l = $y > 0.008856 ? (116 * $y) - 16 : 903.3 * $y;

        $z = $z > 0.008856 ? pow($z, 1 / 3) : (7.787 * $z) + (16 / 116);

        $l = round($l, 2);
        $a = round(500 * ($x - $y), 2);
        $b = round(200 * ($y - $z), 2);

        return [$l, $a, $b];
    }

    /** @return array{int, int, int} */
    public static function xyzValueToRgb(float $x, float $y, float $z): array
    {
        $x = $x / 100;
        $y = $y / 100;
        $z = $z / 100;

        $r = $x * 3.2406 + $y * -1.5372 + $z * -0.4986;
        $g = $x * -0.9689 + $y * 1.8758 + $z * 0.0415;
        $b = $x * 0.0557 + $y * -0.2040 + $z * 1.0570;

        $r = $r > 0.0031308 ? 1.055 * pow($r, (1 / 2.4)) - 0.055 : 12.92 * $r;
        $g = $g > 0.0031308 ? 1.055 * pow($g, (1 / 2.4)) - 0.055 : 12.92 * $g;
        $b = $b > 0.0031308 ? 1.055 * pow($b, (1 / 2.4)) - 0.055 : 12.92 * $b;

        return [
            (int) max(0, min(255, $r * 255)),
            (int) max(0, min(255, $g * 255)),
            (int) max(0, min(255, $b * 255)),
        ];
    }
}
