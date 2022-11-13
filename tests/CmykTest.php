<?php

use Spatie\Color\Cmyk;
use Spatie\Color\Exceptions\InvalidColorValue;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

it('is initializable', function () {
    $cmyk = new Cmyk(0.5, 0.3, 0.2, 0.1);

    assertInstanceOf(Cmyk::class, $cmyk);
    assertSame(0.5, $cmyk->cyan());
    assertSame(0.3, $cmyk->magenta());
    assertSame(0.2, $cmyk->yellow());
    assertSame(0.1, $cmyk->black());
});

it('cant be initialized with invalid cmyk ranges', function () {
    new Cmyk(1.0, 1.0, 1.0, 2);
})->throws(InvalidColorValue::class);

it('can be created from a string', function () {
    $cmyk = Cmyk::fromString('cmyk(100%,50%,10%,25%)');

    assertInstanceOf(Cmyk::class, $cmyk);
    assertSame(1.0, $cmyk->cyan());
    assertSame(0.5, $cmyk->magenta());
    assertSame(0.1, $cmyk->yellow());
    assertSame(0.25, $cmyk->black());
});

it('cant be created from malformed string', function () {
    Cmyk::fromString('cmyk(50%,30%,20%,10%');
})->throws(InvalidColorValue::class);

it('cant be created from a string with text around', function () {
    Cmyk::fromString('abc cmyk(50%,30%,20%,10%) abc');
})->throws(InvalidColorValue::class);

it('can be casted to a string', function () {
    $cmyk = new Cmyk(0.5, 0.3, 0.2, 0.1);
    assertSame('cmyk(50%,30%,20%,10%)', (string)$cmyk);
});

it('can be converted to CIELab', function () {
    $cmyk = new Cmyk(0.17, 0.08, 0, 0.2);
    $lab = $cmyk->toCIELab();

    assertSame(75.04, $lab->l());
    assertSame(-2.61, $lab->a());
    assertSame(-10.65, $lab->b());
});

it('can be converted to hex', function () {
    $cmyk = new Cmyk(0.17, 0.08, 0, 0.2);
    $hex = $cmyk->toHex();

    assertSame('a9', $hex->red());
    assertSame('bb', $hex->green());
    assertSame('cc', $hex->blue());
});

it('can be converted to hsl', function () {
    $cmyk = new Cmyk(0.17, 0.08, 0, 0.2);
    $hsl = $cmyk->toHsl();

    assertSame($cmyk->red(), $hsl->red());
    assertSame($cmyk->green(), $hsl->green());
    assertSame($cmyk->blue(), $hsl->blue());
});

it('can be converted to hsla with a specific alpha value', function () {
    $cmyk = new Cmyk(0.17, 0.08, 0, 0.2);
    $hsla = $cmyk->toHsla(0.75);

    assertSame($cmyk->red(), $hsla->red());
    assertSame($cmyk->green(), $hsla->green());
    assertSame($cmyk->blue(), $hsla->blue());
    assertSame(0.75, $hsla->alpha());
});

it('can be converted to rgb', function () {
    $cmyk = new Cmyk(0.17, 0.08, 0, 0.2);
    $rgb = $cmyk->toRgb();

    assertSame($cmyk->red(), $rgb->red());
    assertSame($cmyk->green(), $rgb->green());
    assertSame($cmyk->blue(), $rgb->blue());
});

it('can be converted to rgba', function () {
    $cmyk = new Cmyk(0.17, 0.08, 0, 0.2);
    $rgba = $cmyk->toRgba(0.5);

    assertSame($cmyk->red(), $rgba->red());
    assertSame($cmyk->green(), $rgba->green());
    assertSame($cmyk->blue(), $rgba->blue());
    assertSame(0.5, $rgba->alpha());
});

it('can be converted to xyz', function () {
    $cmyk = new Cmyk(0.17, 0.08, 0, 0.2);
    $xyz = $cmyk->toXyz();

    assertSame($cmyk->red(), $xyz->red());
    assertSame($cmyk->green(), $xyz->green());
    assertSame($cmyk->blue(), $xyz->blue());
});
