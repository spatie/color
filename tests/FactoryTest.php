<?php

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertStringMatchesFormat;

use Spatie\Color\CIELab;
use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Factory;
use Spatie\Color\Hex;
use Spatie\Color\Hsl;
use Spatie\Color\Hsla;
use Spatie\Color\Rgb;
use Spatie\Color\Rgba;
use Spatie\Color\Xyz;

it('can create a CIELab color from a string', function () {
    $lab = Factory::fromString('CIELab(62.91,5.34,-57.73)');

    assertInstanceOf(CIELab::class, $lab);
});

it('can create a hex color from a string', function () {
    $hex = Factory::fromString('#aabbcc');

    assertInstanceOf(Hex::class, $hex);
});

it('can create a hsl color from a string', function () {
    $hsl = Factory::fromString('hsl(127, 45%, 71%)');

    assertInstanceOf(Hsl::class, $hsl);
});

it('can create a hsla color from a string', function () {
    $hsla = Factory::fromString('hsla(127, 45%, 71%, 0.33)');

    assertInstanceOf(Hsla::class, $hsla);
});

it('can create a rgb color from a string', function () {
    $rgb = Factory::fromString('rgb(55,155,255)');

    assertInstanceOf(Rgb::class, $rgb);
});

it('can create a rgba color from a string', function () {
    $rgba = Factory::fromString('rgba(55,155,255,0.5)');

    assertInstanceOf(Rgba::class, $rgba);
});

it('can create a xyz color from a string', function () {
    $xyz = Factory::fromString('xyz(31.3469,31.4749,99.0308)');

    assertInstanceOf(Xyz::class, $xyz);
});

it('cant create a color from malformed string', function () {
    Factory::fromString('abcde');
})->throws(InvalidColorValue::class);

it('should convert edge case', function (string $hex, string $rgb, string $hsla) {
    $sut = Factory::fromString($hex);

    assertStringMatchesFormat($hex, (string) $sut->toHex(), '');
    assertStringMatchesFormat($rgb, (string) $sut->toRgb(), '');
    assertStringMatchesFormat($hsla, (string) $sut->toHsla(), '');

    assertStringMatchesFormat($hex, (string) $sut->toRgb()->toHex(), '');
    assertStringMatchesFormat($hsla, (string) $sut->toRgb()->toHsla(), '');

    assertStringMatchesFormat($rgb, (string) $sut->toHex()->toRgb(), '');
    assertStringMatchesFormat($hsla, (string) $sut->toHex()->toHsla(), '');
})->with('colors');
