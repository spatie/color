<?php

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotSame;
use function PHPUnit\Framework\assertSame;

use Spatie\Color\CIELab;
use Spatie\Color\Exceptions\InvalidColorValue;

it('is initializable', function () {
    $lab = new CIELab(62.91, 5.34, -57.73);

    assertInstanceOf(CIELab::class, $lab);
    assertSame(62.91, $lab->l());
    assertSame(5.34, $lab->a());
    assertSame(-57.73, $lab->b());
});

it('cant be initialized with a negative l value', function () {
    new CIELab(-5.00, 5.34, -57.73);
})->throws(InvalidColorValue::class);

it('cant be initialized with an l value higher than 100', function () {
    new CIELab(150.00, 5.34, -57.73);
})->throws(InvalidColorValue::class);

it('cant be initialized with an a value lower than negative 110', function () {
    new CIELab(62.91, -150.00, -57.73);
})->throws(InvalidColorValue::class);

it('cant be initialized with an a value higher than 110', function () {
    new CIELab(62.91, 150.00, -57.73);
})->throws(InvalidColorValue::class);

it('cant be initialized with a b value lower than negative 110', function () {
    new CIELab(62.91, 5.34, -150.00);
})->throws(InvalidColorValue::class);

it('cant be initialized with a b value higher than 110', function () {
    new CIELab(62.91, 5.34, 150.00);
})->throws(InvalidColorValue::class);

it('can be created from a string', function () {
    $lab = CIELab::fromString('CIELab(62.91,5.34,-57.73)');

    assertInstanceOf(CIELab::class, $lab);
    assertSame(62.91, $lab->l());
    assertSame(5.34, $lab->a());
    assertSame(-57.73, $lab->b());
});

it('can be created from a string with spaces', function () {
    $lab = CIELab::fromString('  CIELab(  62.91,  5.34,  -57.73  )  ');

    assertInstanceOf(CIELab::class, $lab);
    assertSame(62.91, $lab->l());
    assertSame(5.34, $lab->a());
    assertSame(-57.73, $lab->b());
});

it('cant be created from malformed string', function () {
    CIELab::fromString('CIELab(62.91,5.34,-57.73');
})->throws(InvalidColorValue::class);

it('cant be created from a string with text around', function () {
    CIELab::fromString('abc CIELab(62.91,5.34,-57.73) abc');
})->throws(InvalidColorValue::class);

it('can be casted to a string', function () {
    $lab = new CIELab(62.91, 5.34, -57.73);

    assertSame('CIELab(62.91,5.34,-57.73)', (string) $lab);
});

it('can be converted to CIELab', function () {
    $lab = new CIELab(62.91, 5.34, -57.73);
    $newLab = $lab->toCIELab();

    assertSame($lab->l(), $newLab->l());
    assertSame($lab->a(), $newLab->a());
    assertSame($lab->b(), $newLab->b());
    assertNotSame($lab, $newLab);
});

it('can be converted to cmyk', function () {
    $lab = new CIELab(62.91, 5.34, -57.73);
    $cmyk = $lab->toCmyk();

    assertSame($lab->red(), $cmyk->red());
    assertSame($lab->green(), $cmyk->green());
    assertSame($lab->blue(), $cmyk->blue());
});

it('can be converted to rgb', function () {
    $lab = new CIELab(62.91, 5.34, -57.73);
    $rgb = $lab->toRgb();

    assertSame(55, $rgb->red());
    assertSame(155, $rgb->green());
    assertSame(255, $rgb->blue());
});

it('can be converted to rgba with a specific alpha value', function () {
    $lab = new CIELab(62.91, 5.34, -57.73);
    $rgba = $lab->toRgba(0.5);

    assertSame(55, $rgba->red());
    assertSame(155, $rgba->green());
    assertSame(255, $rgba->blue());
    assertSame(0.5, $rgba->alpha());
});

it('can be converted to hex', function () {
    $lab = new CIELab(62.91, 5.34, -57.73);
    $hex = $lab->toHex();

    assertSame('37', $hex->red());
    assertSame('9b', $hex->green());
    assertSame('ff', $hex->blue());
});

it('can be converted to hsl', function () {
    $lab = new CIELab(62.91, 5.34, -57.73);
    $hsl = $lab->toHsl();

    assertSame(55, $hsl->red());
    assertSame(155, $hsl->green());
    assertSame(255, $hsl->blue());
});

it('can be converted to hsla with a specific alpha value', function () {
    $lab = new CIELab(62.91, 5.34, -57.73);
    $hsla = $lab->toHsla(0.5);

    assertSame(55, $hsla->red());
    assertSame(155, $hsla->green());
    assertSame(255, $hsla->blue());
    assertSame(0.5, $hsla->alpha());
});

it('can be converted to xyz', function () {
    $lab = new CIELab(62.91, 5.34, -57.73);
    $xyz = $lab->toXyz();

    assertSame(31.3514, $xyz->x());
    assertSame(31.4791, $xyz->y());
    assertSame(99.0395, $xyz->z());
});
