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
}
