<?php

use Spatie\Color\Distance;
use Spatie\Color\Hex;
use Spatie\Color\Rgb;
use function PHPUnit\Framework\assertSame;

it('can compare distance using CIE76', function () {
    $color1 = Rgb::fromString('rgb(55,155,255)');
    $color2 = Hex::fromString('#2d78c8');
    $distance = Distance::CIE76($color1, $color2);

    assertSame(16.35058714542080, $distance);
});

it('can compare distance using CIE76 and string colors', function () {
    $distance = Distance::CIE76('rgb(55,155,255)', '#2d78c8');

    assertSame(16.35058714542080, $distance);
});

it('can compare distance using CIE94', function () {
    $color1 = Rgb::fromString('rgb(55,155,255)');
    $color2 = Hex::fromString('#2d78c8');
    $distance = Distance::CIE94($color1, $color2);

    assertSame(13.49091942790753, $distance);
});

it('can compare distance using CIE94 and string colors', function () {
    $distance = Distance::CIE94('rgb(55,155,255)', '#2d78c8');

    assertSame(13.49091942790753, $distance);
});

it('can compare distance using CIEDE2000', function () {
    $color1 = Rgb::fromString('rgb(55,155,255)');
    $color2 = Hex::fromString('#2d78c8');
    $distance = Distance::CIEDE2000($color1, $color2);

    assertSame(12.711957696300898, $distance);
});

it('can compare distance using CIEDE2000 and string colors', function () {
    $distance = Distance::CIEDE2000('rgb(55,155,255)', '#2d78c8');

    assertSame(12.711957696300898, $distance);
});
