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
        return dechex($rgbValue);
    }
}
