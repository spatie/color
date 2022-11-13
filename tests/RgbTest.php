<?php

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotSame;
use function PHPUnit\Framework\assertSame;

use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Rgb;

it('is initializable', function () {
    $rgb = new Rgb(55, 155, 255);

    assertInstanceOf(Rgb::class, $rgb);
    assertSame(55, $rgb->red());
    assertSame(155, $rgb->green());
    assertSame(255, $rgb->blue());
});

it('cant be initialized with a negative color value', function () {
    new Rgb(-5, 255, 255);
})->throws(InvalidColorValue::class);

it('cant be initialized with a color value higher than 255', function () {
    new Rgb(300, 255, 255);
})->throws(InvalidColorValue::class);

it('can be created from a string', function () {
    $rgb = Rgb::fromString('rgb(55,155,255)');

    assertInstanceOf(Rgb::class, $rgb);
    assertSame(55, $rgb->red());
    assertSame(155, $rgb->green());
    assertSame(255, $rgb->blue());
});

it('can be created from a string with spaces', function () {
    $rgb = Rgb::fromString('  rgb(  55  ,  155  ,  255  )  ');

    assertInstanceOf(Rgb::class, $rgb);
    assertSame(55, $rgb->red());
    assertSame(155, $rgb->green());
    assertSame(255, $rgb->blue());
});

it('cant be created from malformed string', function () {
    Rgb::fromString('rgb(55,155,255');
})->throws(InvalidColorValue::class);

it('cant be created from a string with text around', function () {
    Rgb::fromString('abc rgb(55,155,255) abc');
})->throws(InvalidColorValue::class);

it('can be casted to a string', function () {
    $rgb = new Rgb(55, 155, 255);

    assertSame('rgb(55,155,255)', (string) $rgb);
});

it('can be converted to CIELab', function () {
    $rgb = new Rgb(55, 155, 255);
    $lab = $rgb->toCIELab();

    assertSame(62.91, $lab->l());
    assertSame(5.34, $lab->a());
    assertSame(-57.73, $lab->b());
});

it('can be converted to cmyk', function () {
    $rgb = new Rgb(55, 155, 255);
    $cmyk = $rgb->toCmyk();

    assertSame($rgb->red(), $cmyk->red());
    assertSame($rgb->green(), $cmyk->green());
    assertSame($rgb->blue(), $cmyk->blue());
});

it('can be converted to rgb', function () {
    $rgb = new Rgb(55, 155, 255);
    $newRgb = $rgb->toRgb();

    assertSame($rgb->red(), $newRgb->red());
    assertSame($rgb->green(), $newRgb->green());
    assertSame($rgb->blue(), $newRgb->blue());
    assertNotSame($rgb, $newRgb);
});

it('can be converted to rgba with a specific alpha value', function () {
    $rgb = new Rgb(55, 155, 255);
    $rgba = $rgb->toRgba(0.5);

    assertSame(55, $rgba->red());
    assertSame(155, $rgba->green());
    assertSame(255, $rgba->blue());
    assertSame(0.5, $rgba->alpha());
});

it('can be converted to hex', function () {
    $rgb = new Rgb(55, 155, 255);
    $hex = $rgb->toHex();

    assertSame('37', $hex->red());
    assertSame('9b', $hex->green());
    assertSame('ff', $hex->blue());
});

it('can be converted to hsb', function () {
    $rgb = new Rgb(128, 102, 102);
    $hsb = $rgb->toHsb();

    assertSame(0.0, $hsb->hue());
    assertSame(20.0, $hsb->saturation());
    assertSame(50.0, $hsb->brightness());
});

it('can be converted to hsl', function () {
    $rgb = new Rgb(55, 155, 255);
    $hsl = $rgb->toHsl();

    assertSame(55, $hsl->red());
    assertSame(155, $hsl->green());
    assertSame(255, $hsl->blue());
});

it('can be converted to hsla with a specific alpha value', function () {
    $rgb = new Rgb(55, 155, 255);
    $hsla = $rgb->toHsla(0.5);

    assertSame(55, $hsla->red());
    assertSame(155, $hsla->green());
    assertSame(255, $hsla->blue());
    assertSame(0.5, $hsla->alpha());
});

it('can be converted to xyz', function () {
    $rgb = new Rgb(55, 155, 255);
    $xyz = $rgb->toXyz();

    assertSame(31.3469, $xyz->x());
    assertSame(31.4749, $xyz->y());
    assertSame(99.0308, $xyz->z());
})->skip();
