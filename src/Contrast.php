<?php


namespace Spatie\Color;


class Contrast
{
    /**
     * @param Hex|Hsl|Hsla|Rgb|Rgba $color
     * @return int
     */
    public static function ratio($color): int
    {
        if (! $color instanceof Hex) {
            $color = $color->toHex();
        }

        $L1 =
            0.2126 * pow(hexdec($color->red()) / 255, 2.2) +
            0.7152 * pow(hexdec($color->green()) / 255, 2.2) +
            0.0722 * pow(hexdec($color->blue()) / 255, 2.2);

        $L2 =
            0.2126 * pow(hexdec('00') / 255, 2.2) +
            0.7152 * pow(hexdec('00') / 255, 2.2) +
            0.0722 * pow(hexdec('00') / 255, 2.2);

        if ($L1 > $L2) {
            return (int) (($L1 + 0.05) / ($L2 + 0.05));
        }
        else {
            return (int) (($L2 + 0.05) / ($L1 + 0.05));
        }
    }

    /**
     * @param Hex|Hsl|Hsla|Rgb|Rgba $color
     * @return Hex
     */
    public static function make($color): Hex
    {
        if (! $color instanceof Hex) {
            $color = $color->toHex();
        }

        if (static::ratio($color) > 5) {
            return Hex::fromString('#000000');
        }
        else {
            return Hex::fromString('#FFFFFF');
        }
    }
}
