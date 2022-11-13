<?php

use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Hsb;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

it('is initializable', function () {
    $hsb = new Hsb(55, 55, 67);

    assertInstanceOf(Hsb::class, $hsb);
    assertSame(55.0, $hsb->hue());
    assertSame(55.0, $hsb->saturation());
    assertSame(67.0, $hsb->brightness());
});

it('cant be initialized with a negative saturation', function () {
    new Hsb(-5, -1, 67);
})->throws(InvalidColorValue::class);

it('cant be initialized with a saturation higher than 100', function () {
    new Hsb(-5, 105, 67);
})->throws(InvalidColorValue::class);

it('cant be initialized with a negative brightness', function () {
    new Hsb(-5, 55, -67);
})->throws(InvalidColorValue::class);

it('cant be initialized with a brightness higher than 100', function () {
    new Hsb(-5, 55, 107);
})->throws(InvalidColorValue::class);

it('can be created from a string', function () {
    $hsb = Hsb::fromString('hsb(205,35%,17%)');

    assertInstanceOf(Hsb::class, $hsb);
    assertSame(205.0, $hsb->hue());
    assertSame(35.0, $hsb->saturation());
    assertSame(17.0, $hsb->brightness());
});

it('can be created from a string without percentages', function () {
    $hsb = Hsb::fromString('hsb(205,35,17)');

    assertInstanceOf(Hsb::class, $hsb);
    assertSame(205.0, $hsb->hue());
    assertSame(35.0, $hsb->saturation());
    assertSame(17.0, $hsb->brightness());
});

it('can be created from a string with spaces', function () {
    $hsb = Hsb::fromString('  hsb(  205  ,  35%  ,  17%  )  ');

    assertInstanceOf(Hsb::class, $hsb);
    assertSame(205.0, $hsb->hue());
    assertSame(35.0, $hsb->saturation());
    assertSame(17.0, $hsb->brightness());
});

it('cant be created from malformed string', function () {
    Hsb::fromString('hsb(55,155,255');
})->throws(InvalidColorValue::class);

it('cant be created from a string with text around', function () {
    Hsb::fromString('abc hsb(55,155,255) abc');
})->throws(InvalidColorValue::class);

it('can be casted to a string', function () {
    $hsb = new Hsb(55, 15, 25);

    assertSame('hsb(55,15%,25%)', (string) $hsb);
});

it('can be converted to CIELab', function () {
    $hsb = new Hsb(50, 50, 50);
    $lab = $hsb->toCIELab();

    assertSame(49.11, $lab->l());
    assertSame(-3.48, $lab->a());
    assertSame(30.6, $lab->b());
});

it('can be converted to cmyk', function () {
    $hsb = new Hsb(55, 55, 67);
    $cmyk = $hsb->toCmyk();

    assertSame($hsb->red(), $cmyk->red());
    assertSame($hsb->green(), $cmyk->green());
    assertSame($hsb->blue(), $cmyk->blue());
});

it('can be converted to rgb', function () {
    $hsb = new Hsb(50, 50, 50);
    $rgb = $hsb->toRgb();

    assertSame(128, $rgb->red());
    assertSame(117, $rgb->green());
    assertSame(64, $rgb->blue());
});

it('can be converted to rgba with a specific alpha value', function () {
    $hsb = new Hsb(50, 50, 50);
    $rgba = $hsb->toRgba(0.5);

    assertSame(128, $rgba->red());
    assertSame(117, $rgba->green());
    assertSame(64, $rgba->blue());
    assertSame(0.5, $rgba->alpha());
});

it('can be converted to hex', function () {
    $hsb = new Hsb(50, 50, 50);
    $hex = $hsb->toHex();

    assertSame('80', $hex->red());
    assertSame('75', $hex->green());
    assertSame('40', $hex->blue());
});

it('can be converted to xyz', function () {
    $hsb = new Hsb(55, 55, 67);
    $xyz = $hsb->toXyz();

    assertSame(55.1174, $xyz->x());
    assertSame(61.8333, $xyz->y());
    assertSame(28.4321, $xyz->z());
})->skip();
