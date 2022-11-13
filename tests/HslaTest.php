<?php

use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Hsla;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotSame;
use function PHPUnit\Framework\assertSame;

it('is initializable', function () {
    $hsla = new Hsla(55, 55, 67, 0.5);

    assertInstanceOf(Hsla::class, $hsla);
    assertSame(55.0, $hsla->hue());
    assertSame(55.0, $hsla->saturation());
    assertSame(67.0, $hsla->lightness());
    assertSame(0.5, $hsla->alpha());
});

it('cant be initialized with a negative saturation', function () {
    $this->expectException(InvalidColorValue::class);

    new Hsla(-5, -1, 67);
});

it('cant be initialized with a saturation higher than 100', function () {
    $this->expectException(InvalidColorValue::class);

    new Hsla(-5, 108, 67);
});

it('cant be initialized with a negative lightness', function () {
    $this->expectException(InvalidColorValue::class);

    new Hsla(-5, 55, -67);
});

it('cant be initialized with a lightness higher than 100', function () {
    $this->expectException(InvalidColorValue::class);

    new Hsla(-5, 55, 102);
});

it('cant be initialized with a negative alpha value', function () {
    $this->expectException(InvalidColorValue::class);

    new Hsla(255, 55, 25, -1);
});

it('cant be initialized with an alpha value higher than 1', function () {
    $this->expectException(InvalidColorValue::class);

    new Hsla(255, 0.25, 55, 1.5);
});

it('can be created from a string', function () {
    $hsla = Hsla::fromString('hsla(205,35%,17%,0.78)');

    assertInstanceOf(Hsla::class, $hsla);
    assertSame(205.0, $hsla->hue());
    assertSame(35.0, $hsla->saturation());
    assertSame(17.0, $hsla->lightness());
    assertSame(0.78, $hsla->alpha());
});

it('can be created from a string without percentages', function () {
    $hsla = Hsla::fromString('hsla(205,35,17,0.78)');

    assertInstanceOf(Hsla::class, $hsla);
    assertSame(205.0, $hsla->hue());
    assertSame(35.0, $hsla->saturation());
    assertSame(17.0, $hsla->lightness());
    assertSame(0.78, $hsla->alpha());
});

it('can be created from a string with spaces', function () {
    $hsla = Hsla::fromString('  hsla(  205  ,  35%  ,  17%  ,  0.89  )  ');

    assertInstanceOf(Hsla::class, $hsla);
    assertSame(205.0, $hsla->hue());
    assertSame(35.0, $hsla->saturation());
    assertSame(17.0, $hsla->lightness());
    assertSame(0.89, $hsla->alpha());
});

it('cant be created from malformed string', function () {
    $this->expectException(InvalidColorValue::class);

    Hsla::fromString('hsla(205,0.35,0.17,0.78');
});

it('cant be created from a string with text around', function () {
    $this->expectException(InvalidColorValue::class);

    Hsla::fromString('abc hsla(205,0.35,0.17,0.78) abc');
});

it('can be casted to a string', function () {
    $hsla = new Hsla(55, 15, 25, 0.4);

    assertSame('hsla(55,15%,25%,0.4)', (string) $hsla);
});

it('calculates rgb values', function (string $hslaString, int $red, int $green, int $blue) {
    $hsla = Hsla::fromString($hslaString);

    assertSame($red, $hsla->red());
    assertSame($green, $hsla->green());
    assertSame($blue, $hsla->blue());
})->with('hsla_string_and_rgb_values');

it('can be converted to CIELab', function () {
    $hsla = new Hsla(55, 15, 25, 0.4);
    $lab = $hsla->toCIELab();

    assertSame(30.20, $lab->l());
    assertSame(-3.07, $lab->a());
    assertSame(10.98, $lab->b());
});

it('can be converted to cmyk', function () {
    $hsla = new Hsla(55, 15, 25, 0.4);
    $cmyk = $hsla->toCmyk();

    assertSame($hsla->red(), $cmyk->red());
    assertSame($hsla->green(), $cmyk->green());
    assertSame($hsla->blue(), $cmyk->blue());
});

it('can be converted to hsla', function () {
    $hsla = new Hsla(55, 55, 67);
    $newHsla = $hsla->toHsla(0.5);

    assertSame($hsla->hue(), $newHsla->hue());
    assertSame($hsla->saturation(), $newHsla->saturation());
    assertSame($hsla->lightness(), $newHsla->lightness());
    assertSame(0.5, $newHsla->alpha());
    assertNotSame($hsla, $newHsla);
});

it('can be converted to hsl', function () {
    $hsla = new Hsla(55, 55, 67);
    $hsl = $hsla->toHsl();

    assertSame($hsla->hue(), $hsl->hue());
    assertSame($hsla->saturation(), $hsl->saturation());
    assertSame($hsla->lightness(), $hsl->lightness());
});

it('can be converted to rgb', function () {
    $hsla = new Hsla(55, 55, 67);
    $rgb = $hsla->toRgb();

    assertSame(217, $rgb->red());
    assertSame(209, $rgb->green());
    assertSame(125, $rgb->blue());
});

it('can be converted to rgba with a specific alpha value', function () {
    $hsla = new Hsla(55, 55, 67);
    $rgba = $hsla->toRgba(0.5);

    assertSame(217, $rgba->red());
    assertSame(209, $rgba->green());
    assertSame(125, $rgba->blue());
    assertSame(0.5, $rgba->alpha());
});

it('can be converted to hex', function () {
    $hsla = new Hsla(55, 55, 67);
    $hex = $hsla->toHex();

    assertSame('d9', $hex->red());
    assertSame('d1', $hex->green());
    assertSame('7d', $hex->blue());
});

it('can be converted to xyz', function () {
    $hsla = new Hsla(55, 55, 67);
    $xyz = $hsla->toXyz();

    assertSame(55.1174, $xyz->x());
    assertSame(61.8333, $xyz->y());
    assertSame(28.4321, $xyz->z());
})->skip();
