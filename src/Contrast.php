<?php

namespace Spatie\Color;

class Contrast
{
    public static function ratio(Color $a, Color $b): float
    {
        $a = $a instanceof Hex ? $a : $a->toHex();
        $b = $b instanceof Hex ? $b : $b->toHex();

        $l1 = self::calculateLuminance($a);
        $l2 = self::calculateLuminance($b);

        return round(
            ($l1 > $l2)
                ? ($l1 + 0.05) / ($l2 + 0.05)
                : ($l2 + 0.05) / ($l1 + 0.05),
            2
        );
    }

    public static function calculateLuminance(Hex $color): float
    {
        return
            0.2126 * pow(hexdec($color->red()) / 255, 2.2) +
            0.7152 * pow(hexdec($color->green()) / 255, 2.2) +
            0.0722 * pow(hexdec($color->blue()) / 255, 2.2);
    }
}
