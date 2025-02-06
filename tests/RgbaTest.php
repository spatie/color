<?php

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotSame;
use function PHPUnit\Framework\assertSame;

use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Rgba;

it('is initializable', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);

    assertInstanceOf(Rgba::class, $rgba);
    assertSame(55, $rgba->red());
    assertSame(155, $rgba->green());
    assertSame(255, $rgba->blue());
    assertSame(0.5, $rgba->alpha());
});

it('cant be initialized with a negative color value', function () {
    new Rgba(-5, 255, 255, 0.5);
})->throws(InvalidColorValue::class);

it('cant be initialized with a color value higher than 255', function () {
    new Rgba(300, 255, 255, 0.5);
})->throws(InvalidColorValue::class);

it('cant be initialized with a negative alpha value', function () {
    new Rgba(255, 255, 255, -1);
})->throws(InvalidColorValue::class);

it('cant be initialized with an alpha value higher than 1', function () {
    new Rgba(255, 255, 255, 1.5);
})->throws(InvalidColorValue::class);

it('can be created from a string', function () {
    $rgba = Rgba::fromString('rgba(55,155,255,0.5)');

    assertInstanceOf(Rgba::class, $rgba);
    assertSame(55, $rgba->red());
    assertSame(155, $rgba->green());
    assertSame(255, $rgba->blue());
    assertSame(0.5, $rgba->alpha());
});

it('can be created with an opacity value without leading zero', function () {
    $rgba = Rgba::fromString('rgba(55,155,255,.555)');

    assertInstanceOf(Rgba::class, $rgba);
    assertSame(55, $rgba->red());
    assertSame(155, $rgba->green());
    assertSame(255, $rgba->blue());
    assertSame(.555, $rgba->alpha());
});

it('can be created from a string with 3 decimals in opacity', function () {
    $rgba = Rgba::fromString('rgba(55,155,255,0.555)');

    assertInstanceOf(Rgba::class, $rgba);
    assertSame(55, $rgba->red());
    assertSame(155, $rgba->green());
    assertSame(255, $rgba->blue());
    assertSame(0.555, $rgba->alpha());
});

it('can be created from a string with spaces', function () {
    $rgba = Rgba::fromString('  rgba(  55  ,  155  ,  255  ,  0.5  )  ');

    assertInstanceOf(Rgba::class, $rgba);
    assertSame(55, $rgba->red());
    assertSame(155, $rgba->green());
    assertSame(255, $rgba->blue());
    assertSame(0.5, $rgba->alpha());
});

it('cant be created from malformed string', function () {
    Rgba::fromString('rgba(55,155,255,0.5');
})->throws(InvalidColorValue::class);

it('cant be created from a string with text around', function () {
    Rgba::fromString('abc rgba(55,155,255,0.5) abc');
})->throws(InvalidColorValue::class);

it('can be casted to a string', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);

    assertSame('rgba(55,155,255,0.50)', (string) $rgba);
});

it('can be converted to CIELab', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);
    $lab = $rgba->toCIELab();

    assertSame(62.91, $lab->l());
    assertSame(5.34, $lab->a());
    assertSame(-57.73, $lab->b());
});

it('can be converted to cmyk', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);
    $cmyk = $rgba->toCmyk();

    assertSame($rgba->red(), $cmyk->red());
    assertSame($rgba->green(), $cmyk->green());
    assertSame($rgba->blue(), $cmyk->blue());
});

it('can be converted to rgba', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);
    $newRgba = $rgba->toRgba();

    assertSame(serialize($rgba), serialize($newRgba));
});

it('can be converted to rgba with with a specific alpha value', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);
    $newRgba = $rgba->toRgba(0.7);

    assertSame(55, $newRgba->red());
    assertSame(155, $newRgba->green());
    assertSame(255, $newRgba->blue());
    assertSame(0.7, $newRgba->alpha());
    assertNotSame(serialize($rgba), serialize($newRgba));
});

it('can be converted to rgb without an alpha value', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);
    $rgb = $rgba->toRgb();

    assertSame(55, $rgb->red());
    assertSame(155, $rgb->green());
    assertSame(255, $rgb->blue());
});

it('can be converted to hex', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);
    $hex = $rgba->toHex();

    assertSame('37', $hex->red());
    assertSame('9b', $hex->green());
    assertSame('ff', $hex->blue());
    assertSame('80', $hex->alpha());
});

it('can be converted to hex with a specific alpha value', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);
    $hex = $rgba->toHex('dd');

    assertSame('37', $hex->red());
    assertSame('9b', $hex->green());
    assertSame('ff', $hex->blue());
    assertSame('dd', $hex->alpha());
});

it('can be converted to hsl without an alpha value', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);
    $hsl = $rgba->toHsl();

    assertSame(55, $hsl->red());
    assertSame(155, $hsl->green());
    assertSame(255, $hsl->blue());
});

it('can be converted to hsla', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);
    $hsla = $rgba->toHsla();

    assertSame(55, $hsla->red());
    assertSame(155, $hsla->green());
    assertSame(255, $hsla->blue());
    assertSame(0.5, $hsla->alpha());
});

it('can be converted to hsla with a specific alpha value', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);
    $hsla = $rgba->toHsla(0.75);

    assertSame(55, $hsla->red());
    assertSame(155, $hsla->green());
    assertSame(255, $hsla->blue());
    assertSame(0.75, $hsla->alpha());
});

it('can be converted to xyz', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);
    $xyz = $rgba->toXyz();

    assertSame(31.3469, $xyz->x());
    assertSame(31.4749, $xyz->y());
    assertSame(99.0308, $xyz->z());
});
