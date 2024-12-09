<?php

namespace Spatie\Color;

class Contrast
{
    public static function ratio(Color $a, Color $b): float
    {
        if (! $a instanceof Hex) {
            $a = $a->toHex();
        }

        if (! $b instanceof Hex) {
            $b = $b->toHex();
        }

        $l1 =
            0.2126 * pow(hexdec($a->red()) / 255, 2.2) +
            0.7152 * pow(hexdec($a->green()) / 255, 2.2) +
            0.0722 * pow(hexdec($a->blue()) / 255, 2.2);

        $l2 =
            0.2126 * pow(hexdec($b->red()) / 255, 2.2) +
            0.7152 * pow(hexdec($b->green()) / 255, 2.2) +
            0.0722 * pow(hexdec($b->blue()) / 255, 2.2);

        if ($l1 > $l2) {
            return (float) (($l1 + 0.05) / ($l2 + 0.05));
        } else {
            return (float) (($l2 + 0.05) / ($l1 + 0.05));
        }
    }
}
