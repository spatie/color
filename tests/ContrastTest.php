<?php

use Spatie\Color\Hex;
use function PHPUnit\Framework\assertSame;

use Spatie\Color\Color;
use Spatie\Color\Contrast;

it('can calculate contrast', function (Color $a, Color $b, float $contrast) {
    assertSame($contrast, Contrast::ratio($a, $b));
})->with('contrast_colors');

it('can calculate contrast from another format', function (Color $a, Color $b, float $contrast) {
    assertSame($contrast, Contrast::ratio($a->toRgba(), $b->toHsl()));
})->with('contrast_colors');

it('calculates the luminance correctly for a white color', function () {
    $white = Hex::fromString('#FFFFFF');
    $luminance = Contrast::calculateLuminance($white);

    expect($luminance)->toBe(1.0);
});

it('calculates the luminance correctly for a black color', function () {
    $black = Hex::fromString('#000000');
    $luminance = Contrast::calculateLuminance($black);

    expect($luminance)->toBe(0.0);
});
