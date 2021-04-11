<?php

namespace Spatie\Color;

class Convert
{
    public static function hexChannelToRgbChannel(string $hexValue): int
    {
        return hexdec($hexValue);
    }

    public static function rgbChannelToHexChannel(int $rgbValue): string
    {
        return str_pad(dechex($rgbValue), 2, '0', STR_PAD_LEFT);
    }

    public static function hslValueToRgb(float $hue, float $saturation, float $lightness): array
    {
        $h = (360 + ($hue % 360)) % 360;  // hue values can be less than 0 and greater than 360. This normalises them into the range 0-360.

        $c = (1 - abs(2 * ($lightness / 100) - 1)) * ($saturation / 100);
        $x = $c * (1 - abs(fmod($h / 60, 2) - 1));
        $m = ($lightness / 100) - ($c / 2);

        if ($h >= 0 && $h <= 60) {
            return [round(($c + $m) * 255), round(($x + $m) * 255), round($m * 255)];
        }

        if ($h > 60 && $h <= 120) {
            return [round(($x + $m) * 255), round(($c + $m) * 255), round($m * 255)];
        }

        if ($h > 120 && $h <= 180) {
            return [round($m * 255), round(($c + $m) * 255), round(($x + $m) * 255)];
        }

        if ($h > 180 && $h <= 240) {
            return [round($m * 255), round(($x + $m) * 255), round(($c + $m) * 255)];
        }

        if ($h > 240 && $h <= 300) {
            return [round(($x + $m) * 255), round($m * 255), round(($c + $m) * 255)];
        }

        if ($h > 300 && $h <= 360) {
            return [round(($c + $m) * 255), round($m * 255), round(($x + $m) * 255)];
        }
    }

    public static function rgbValueToHsl($red, $green, $blue): array
    {
        $r = $red / 255;
        $g = $green / 255;
        $b = $blue / 255;

        $cmax = max($r, $g, $b);
        $cmin = min($r, $g, $b);
        $delta = $cmax - $cmin;

        $hue = 0;
        if ($delta != 0) {
            if ($r === $cmax) {
                $hue = 60 * fmod(($g - $b) / $delta, 6);
            }

            if ($g === $cmax) {
                $hue = 60 * ((($b - $r) / $delta) + 2);
            }

            if ($b === $cmax) {
                $hue = 60 * ((($r - $g) / $delta) + 4);
            }
        }

        $lightness = ($cmax + $cmin) / 2;

        $saturation = 0;

        if ($lightness > 0 && $lightness < 1) {
            $saturation = $delta / (1 - abs((2 * $lightness) - 1));
        }

        return [$hue, min($saturation, 1) * 100, min($lightness, 1) * 100];
    }

    public static function hslValueToLuminance(
        float $hue,
        float $saturation,
        float $lightness
    ): float {
        [$red, $green, $blue] = self::hslValueToRgb($hue, $saturation, $lightness);

        $red /= 255;
        $green /= 255;
        $blue /= 255;

        $red = $red < 0.03928 ? $red / 12.92 : pow(($red + 0.055) / 1.055, 2.4);
        $green = $green < 0.03928 ? $green / 12.92 : pow(($green + 0.055) / 1.055, 2.4);
        $blue = $blue < 0.03928 ? $blue / 12.92 : pow(($blue + 0.055) / 1.055, 2.4);

        return 21.26 * $red + 71.52 * $green + 7.22 * $blue;
    }

    public static function hslValueFromLuminance(
        float $hue,
        float $saturation,
        float $luminance,
        float $precision = 0.01
    ): array {
        $closest = 100;
        $lightness = 100;

        for ($sampleLightness = 100; $sampleLightness >= 0; $sampleLightness--) {
            $sampleLuminance = self::hslValueToLuminance($hue, $saturation, $sampleLightness);
            $difference = abs($luminance - $sampleLuminance);
            if ($difference < $closest) {
                $lightness = $sampleLightness;
                $closest = $difference;
            }
        }

        $max = $closest + $precision * 100;
        $min = $closest - $precision * 100;
        for ($sampleLightness = $max; $sampleLightness >= $min; $sampleLightness -= $precision) {
            $sampleLuminance = self::hslValueToLuminance($hue, $saturation, $sampleLightness);
            $difference = abs($luminance - $sampleLuminance);
            if ($difference < $closest) {
                $lightness = $sampleLightness;
                $closest = $difference;
            }
        }

        return [$hue, $saturation, $lightness];
    }
}
