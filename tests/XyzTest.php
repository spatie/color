<?php

use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Xyz;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotSame;
use function PHPUnit\Framework\assertSame;

it('is initializable', function () {
    $xyz = new Xyz(31.3469, 31.4749, 99.0308);

    assertInstanceOf(Xyz::class, $xyz);
    assertSame(31.3469, $xyz->x());
    assertSame(31.4749, $xyz->y());
    assertSame(99.0308, $xyz->z());
});

it('cant be initialized with a negative x value', function () {
    $this->expectException(InvalidColorValue::class);

    new Xyz(-5.00, 31.4749, 99.0308);
});

it('cant be initialized with an x value higher than 95 047', function () {
    $this->expectException(InvalidColorValue::class);

    new Xyz(100.00, 31.4749, 99.0308);
});

it('cant be initialized with a negative y value', function () {
    $this->expectException(InvalidColorValue::class);

    new Xyz(31.3469, -5.00, 99.0308);
});

it('cant be initialized with a y value higher than 100', function () {
    $this->expectException(InvalidColorValue::class);

    new Xyz(31.3469, 150.00, 99.0308);
});

it('cant be initialized with a negative z value', function () {
    $this->expectException(InvalidColorValue::class);

    new Xyz(31.3469, 31.4749, -5.00);
});

it('cant be initialized with a z value higher than 108 883', function () {
    $this->expectException(InvalidColorValue::class);

    new Xyz(31.3469, 31.4749, 150.00);
});

it('can be created from a string', function () {
    $xyz = Xyz::fromString('xyz(31.3469,31.4749,99.0308)');

    assertInstanceOf(Xyz::class, $xyz);
    assertSame(31.3469, $xyz->x());
    assertSame(31.4749, $xyz->y());
    assertSame(99.0308, $xyz->z());
});

it('can be created from a string with spaces', function () {
    $xyz = Xyz::fromString('  xyz(  31.3469  ,  31.4749  ,  99.0308  )  ');

    assertInstanceOf(Xyz::class, $xyz);
    assertSame(31.3469, $xyz->x());
    assertSame(31.4749, $xyz->y());
    assertSame(99.0308, $xyz->z());
});

it('cant be created from malformed string', function () {
    $this->expectException(InvalidColorValue::class);

    Xyz::fromString('xyz(31.3469,31.4749,99.0308');
});

it('cant be created from a string with text around', function () {
    $this->expectException(InvalidColorValue::class);

    Xyz::fromString('abc xyz(31.3469,31.4749,99.0308) abc');
});

it('can be casted to a string', function () {
    $xyz = new Xyz(31.3469, 31.4749, 99.0308);

    assertSame('xyz(31.3469,31.4749,99.0308)', (string) $xyz);
});

it('can be converted to CIELab', function () {
    $xyz = new Xyz(31.3469, 31.4749, 99.0308);
    $lab = $xyz->toCIELab();

    assertSame(62.91, $lab->l());
    assertSame(5.34, $lab->a());
    assertSame(-57.73, $lab->b());
});

it('can be converted to cmyk', function () {
    $xyz = new Xyz(31.3469, 31.4749, 99.0308);
    $cmyk = $xyz->toCmyk();

    assertSame($xyz->red(), $cmyk->red());
    assertSame($xyz->green(), $cmyk->green());
    assertSame($xyz->blue(), $cmyk->blue());
});

it('can be converted to rgb', function () {
    $xyz = new Xyz(31.3469, 31.4749, 99.0308);
    $rgb = $xyz->toRgb();

    assertSame(55, $rgb->red());
    assertSame(155, $rgb->green());
    assertSame(255, $rgb->blue());
});

it('can be converted to rgba with a specific alpha value', function () {
    $xyz = new Xyz(31.3469, 31.4749, 99.0308);
    $rgba = $xyz->toRgba(0.5);

    assertSame(55, $rgba->red());
    assertSame(155, $rgba->green());
    assertSame(255, $rgba->blue());
    assertSame(0.5, $rgba->alpha());
});

it('can be converted to hex', function () {
    $xyz = new Xyz(31.3469, 31.4749, 99.0308);
    $hex = $xyz->toHex();

    assertSame('37', $hex->red());
    assertSame('9b', $hex->green());
    assertSame('ff', $hex->blue());
});

it('can be converted to hsl', function () {
    $xyz = new Xyz(31.3469, 31.4749, 99.0308);
    $hsl = $xyz->toHsl();

    assertSame(55, $hsl->red());
    assertSame(155, $hsl->green());
    assertSame(255, $hsl->blue());
});

it('can be converted to hsla with a specific alpha value', function () {
    $xyz = new Xyz(31.3469, 31.4749, 99.0308);
    $hsla = $xyz->toHsla(0.5);

    assertSame(55, $hsla->red());
    assertSame(155, $hsla->green());
    assertSame(255, $hsla->blue());
    assertSame(0.5, $hsla->alpha());
});

it('can be converted to xyz', function () {
    $xyz = new Xyz(31.3469, 31.4749, 99.0308);
    $newXyz = $xyz->toXyz();

    assertSame($xyz->x(), $newXyz->x());
    assertSame($xyz->y(), $newXyz->y());
    assertSame($xyz->z(), $newXyz->z());
    assertNotSame($xyz, $newXyz);
});
