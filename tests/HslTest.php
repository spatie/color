<?php

use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Hsl;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotSame;
use function PHPUnit\Framework\assertSame;

it('is initializable', function () {
    $hsl = new Hsl(55, 55, 67);

    assertInstanceOf(Hsl::class, $hsl);
    assertSame(55.0, $hsl->hue());
    assertSame(55.0, $hsl->saturation());
    assertSame(67.0, $hsl->lightness());
});

it('cant be initialized with a negative saturation', function () {
    new Hsl(-5, -1, 67);
})->throws(InvalidColorValue::class);

it('cant be initialized with a saturation higher than 100', function () {
    new Hsl(-5, 105, 67);
})->throws(InvalidColorValue::class);

it('cant be initialized with a negative lightness', function () {
    new Hsl(-5, 55, -67);
})->throws(InvalidColorValue::class);

it('cant be initialized with a lightness higher than 100', function () {
    new Hsl(-5, 55, 107);
})->throws(InvalidColorValue::class);

it('can be created from a string', function () {
    $hsl = Hsl::fromString('hsl(205,35%,17%)');

    assertInstanceOf(Hsl::class, $hsl);
    assertSame(205.0, $hsl->hue());
    assertSame(35.0, $hsl->saturation());
    assertSame(17.0, $hsl->lightness());
});

it('can be created from a string without percentages', function () {
    $hsl = Hsl::fromString('hsl(205,35,17)');

    assertInstanceOf(Hsl::class, $hsl);
    assertSame(205.0, $hsl->hue());
    assertSame(35.0, $hsl->saturation());
    assertSame(17.0, $hsl->lightness());
});

it('can be created from a string with spaces', function () {
    $hsl = Hsl::fromString('  hsl(  205  ,  35%  ,  17%  )  ');

    assertInstanceOf(Hsl::class, $hsl);
    assertSame(205.0, $hsl->hue());
    assertSame(35.0, $hsl->saturation());
    assertSame(17.0, $hsl->lightness());
});

it('cant be created from malformed string', function () {
    Hsl::fromString('hsl(55,155,255');
})->throws(InvalidColorValue::class);

it('cant be created from a string with text around', function () {
    Hsl::fromString('abc hsl(55,155,255) abc');
})->throws(InvalidColorValue::class);

it('can be casted to a string', function () {
    $hsl = new Hsl(55, 15, 25);

    assertSame('hsl(55,15%,25%)', (string) $hsl);
});

it('calculates rgb values', function (string $hslString, int $red, int $green, int $blue) {
    $hsl = Hsl::fromString($hslString);

    assertSame($red, $hsl->red());
    assertSame($green, $hsl->green());
    assertSame($blue, $hsl->blue());
})->with('hsl_string_and_rgb_values');

it('can be converted to CIELab', function () {
    $hsl = new Hsl(55, 55, 67);
    $lab = $hsl->toCIELab();

    assertSame(82.82, $lab->l());
    assertSame(-9.02, $lab->a());
    assertSame(42.55, $lab->b());
});

it('can be converted to cmyk', function () {
    $hsl = new Hsl(55, 55, 67);
    $cmyk = $hsl->toCmyk();

    assertSame($hsl->red(), $cmyk->red());
    assertSame($hsl->green(), $cmyk->green());
    assertSame($hsl->blue(), $cmyk->blue());
});

it('can be converted to hsl', function () {
    $hsl = new Hsl(55, 55, 67);
    $newHsl = $hsl->toHsl();

    assertSame($hsl->hue(), $newHsl->hue());
    assertSame($hsl->saturation(), $newHsl->saturation());
    assertSame($hsl->lightness(), $newHsl->lightness());
    assertNotSame($hsl, $newHsl);
});

it('can be converted to hsla with a specific alpha value', function () {
    $hsl = new Hsl(55, 55, 67);
    $hsla = $hsl->toHsla(0.5);

    assertSame(55.0, $hsla->hue());
    assertSame(55.0, $hsla->saturation());
    assertSame(67.0, $hsla->lightness());
    assertSame(0.5, $hsla->alpha());
});

it('can be converted to rgb', function () {
    $hsl = new Hsl(55, 55, 67);
    $rgb = $hsl->toRgb();

    assertSame(217, $rgb->red());
    assertSame(209, $rgb->green());
    assertSame(125, $rgb->blue());
});

it('can be converted to rgba with a specific alpha value', function () {
    $hsl = new Hsl(55, 55, 67);
    $rgba = $hsl->toRgba(0.5);

    assertSame(217, $rgba->red());
    assertSame(209, $rgba->green());
    assertSame(125, $rgba->blue());
    assertSame(0.5, $rgba->alpha());
});

it('can be converted to hex', function () {
    $hsl = new Hsl(55, 55, 67);
    $hex = $hsl->toHex();

    assertSame('d9', $hex->red());
    assertSame('d1', $hex->green());
    assertSame('7d', $hex->blue());
});

it('can be converted to xyz', function () {
    $hsl = new Hsl(55, 55, 67);
    $xyz = $hsl->toXyz();

    assertSame(55.1174, $xyz->x());
    assertSame(61.8333, $xyz->y());
    assertSame(28.4321, $xyz->z());
})->skip();
