<?php

namespace Spatie\Color;

class Convert
{
    public static function CIELabValueToXyz(float $l, float $a, float $b): array
    {
        $y = ($l + 16) / 116;
        $x = $a / 500 + $y;
        $z = $y - $b / 200;

        if (pow($y, 3) > 0.008856) {
            $y = pow($y, 3);
        } else {
            $y = ($y - 16 / 116) / 7.787;
        }

        if (pow($x, 3) > 0.008856) {
            $x = pow($x, 3);
        } else {
            $x = ($x - 16 / 116) / 7.787;
        }

        if (pow($z, 3) > 0.008856) {
            $z = pow($z, 3);
        } else {
            $z = ($z - 16 / 116) / 7.787;
        }

        $x = round(95.047 * $x, 4);
        $y = round(100.000 * $y, 4);
        $z = round(108.883 * $z, 4);

        if ($x > 95.047) {
            $x = 95.047;
        }
        if ($y > 100) {
            $y = 100;
        }
        if ($z > 108.883) {
            $z = 108.883;
        }

        return [$x, $y, $z];
    }

    public static function cmykValueToRgb(float $cyan, float $magenta, float $yellow, float $key): array
    {
        return [
            255 * (1 - $cyan) * (1 - $key),
            255 * (1 - $magenta) * (1 - $key),
            255 * (1 - $yellow) * (1 - $key)
        ];
    }

    public static function rgbValueToCmyk($red, $green, $blue): array
    {
        $red /= 255;
        $green /= 255;
        $blue /= 255;

        $black = 1 - max($red, $green, $blue);
        $keyNeg = (1 - $black);

        return [
            ($keyNeg - $red) / $keyNeg,
            ($keyNeg - $green) / $keyNeg,
            ($keyNeg - $blue) / $keyNeg,
            $black
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

    public static function hsbValueToRgb($hue, $saturation, $brightness)
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
            $var_H = $hue * 6;
            $var_i = floor($var_H);
            $var_1 = $brightness * (1 - $saturation);
            $var_2 = $brightness * (1 - $saturation * ($var_H - $var_i));
            $var_3 = $brightness * (1 - $saturation * (1 - ($var_H - $var_i)));

            if ($var_i == 0) {
                $var_R = $brightness;
                $var_G = $var_3;
                $var_B = $var_1;
            } else {
                if ($var_i == 1) {
                    $var_R = $var_2;
                    $var_G = $brightness;
                    $var_B = $var_1;
                } else {
                    if ($var_i == 2) {
                        $var_R = $var_1;
                        $var_G = $brightness;
                        $var_B = $var_3;
                    } else {
                        if ($var_i == 3) {
                            $var_R = $var_1;
                            $var_G = $var_2;
                            $var_B = $brightness;
                        } else {
                            if ($var_i == 4) {
                                $var_R = $var_3;
                                $var_G = $var_1;
                                $var_B = $brightness;
                            } else {
                                $var_R = $brightness;
                                $var_G = $var_1;
                                $var_B = $var_2;
                            }
                        }
                    }
                }
            }

            $R = $var_R * 255;
            $G = $var_G * 255;
            $B = $var_B * 255;
        }

        return [round($R), round($G), round($B)];
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

    public static function rgbValueToHsb($red, $green, $blue): array
    {
        $red /= 255;
        $green /= 255;
        $blue /= 255;

        $min = min($red, $green, $blue);
        $max = max($red, $green, $blue);
        $delMax = $max - $min;

        $brightness = $max;
        $hue = 0;

        if ($delMax == 0) {
            $hue = 0;
            $saturation = 0;
        } else {
            $saturation = $delMax / $max;

            $delR = ((($max - $red) / 6) + ($delMax / 2)) / $delMax;
            $delG = ((($max - $green) / 6) + ($delMax / 2)) / $delMax;
            $delB = ((($max - $blue) / 6) + ($delMax / 2)) / $delMax;

            if ($red == $max) {
                $hue = $delB - $delG;
            } else {
                if ($green == $max) {
                    $hue = (1 / 3) + $delR - $delB;
                } else {
                    if ($blue == $max) {
                        $hue = (2 / 3) + $delG - $delR;
                    }
                }
            }

            if ($hue < 0) {
                $hue++;
            }
            if ($hue > 1) {
                $hue--;
            }
        }

        return [round($hue,2) * 360, round($saturation,2) * 100, round($brightness,2) * 100];
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

    public static function rgbValueToXyz($red, $green, $blue): array
    {
        $red = $red / 255;
        $green = $green / 255;
        $blue = $blue / 255;

        if ($red > 0.04045) {
            $red = pow((($red + 0.055) / 1.055), 2.4);
        } else {
            $red = $red / 12.92;
        }

        if ($green > 0.04045) {
            $green = pow((($green + 0.055) / 1.055), 2.4);
        } else {
            $green = $green / 12.92;
        }

        if ($blue > 0.04045) {
            $blue = pow((($blue + 0.055) / 1.055), 2.4);
        } else {
            $blue = $blue / 12.92;
        }

        $red = $red * 100;
        $green = $green * 100;
        $blue = $blue * 100;
        $x = round($red * 0.4124 + $green * 0.3576 + $blue * 0.1805, 4);
        $y = round($red * 0.2126 + $green * 0.7152 + $blue * 0.0722, 4);
        $z = round($red * 0.0193 + $green * 0.1192 + $blue * 0.9505, 4);

        if ($x > 95.047) {
            $x = 95.047;
        }
        if ($y > 100) {
            $y = 100;
        }
        if ($z > 108.883) {
            $z = 108.883;
        }

        return [$x, $y, $z];
    }

    public static function xyzValueToCIELab(float $x, float $y, float $z): array
    {
        $x = $x / 95.047;
        $y = $y / 100.000;
        $z = $z / 108.883;

        if ($x > 0.008856) {
            $x = pow($x, 1 / 3);
        } else {
            $x = (7.787 * $x) + (16 / 116);
        }

        if ($y > 0.008856) {
            $y = pow($y, 1 / 3);
        } else {
            $y = (7.787 * $y) + (16 / 116);
        }

        if ($y > 0.008856) {
            $l = (116 * $y) - 16;
        } else {
            $l = 903.3 * $y;
        }

        if ($z > 0.008856) {
            $z = pow($z, 1 / 3);
        } else {
            $z = (7.787 * $z) + (16 / 116);
        }

        $l = round($l, 2);
        $a = round(500 * ($x - $y), 2);
        $b = round(200 * ($y - $z), 2);

        return [$l, $a, $b];
    }

    public static function xyzValueToRgb(float $x, float $y, float $z): array
    {
        $x = $x / 100;
        $y = $y / 100;
        $z = $z / 100;

        $r = $x * 3.2406 + $y * -1.5372 + $z * -0.4986;
        $g = $x * -0.9689 + $y * 1.8758 + $z * 0.0415;
        $b = $x * 0.0557 + $y * -0.2040 + $z * 1.0570;

        if ($r > 0.0031308) {
            $r = 1.055 * pow($r, (1 / 2.4)) - 0.055;
        } else {
            $r = 12.92 * $r;
        }

        if ($g > 0.0031308) {
            $g = 1.055 * pow($g, (1 / 2.4)) - 0.055;
        } else {
            $g = 12.92 * $g;
        }

        if ($b > 0.0031308) {
            $b = 1.055 * pow($b, (1 / 2.4)) - 0.055;
        } else {
            $b = 12.92 * $b;
        }

        $r = max(0, min(255, $r * 255));
        $g = max(0, min(255, $g * 255));
        $b = max(0, min(255, $b * 255));

        return [$r, $g, $b];
    }
}
