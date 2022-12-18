<?php

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotSame;
use function PHPUnit\Framework\assertSame;

use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Hex;

it('is initializable', function () {
    $hex = new Hex('aa', 'bb', 'cc');

    assertInstanceOf(Hex::class, $hex);
    assertSame('aa', $hex->red());
    assertSame('bb', $hex->green());
    assertSame('cc', $hex->blue());
});

it('cant be initialized with invalid hex string lengths', function () {
    new Hex('a', 'bb', 'cc');
})->throws(InvalidColorValue::class);

it('cant be initialized with invalid hex characters', function () {
    new Hex('gg', 'bb', 'cc');
})->throws(InvalidColorValue::class);

it('can be created from a string', function () {
    $hex = Hex::fromString('#aabbcc');

    assertInstanceOf(Hex::class, $hex);
    assertSame('aa', $hex->red());
    assertSame('bb', $hex->green());
    assertSame('cc', $hex->blue());
});

it('can be created from a short string', function () {
    $hex = Hex::fromString('#abc');

    assertInstanceOf(Hex::class, $hex);
    assertSame('aa', $hex->red());
    assertSame('bb', $hex->green());
    assertSame('cc', $hex->blue());
});

it('can be created from a string with alpha', function () {
    $hex = Hex::fromString('#aabbccdd');

    assertInstanceOf(Hex::class, $hex);
    assertSame('aa', $hex->red());
    assertSame('bb', $hex->green());
    assertSame('cc', $hex->blue());
    assertSame('dd', $hex->alpha());
});

it('can be created from a short string alpha', function () {
    $hex = Hex::fromString('#abcd');

    assertInstanceOf(Hex::class, $hex);
    assertSame('aa', $hex->red());
    assertSame('bb', $hex->green());
    assertSame('cc', $hex->blue());
    assertSame('dd', $hex->alpha());
});

it('cant be created from a string without a hash character', function () {
    Hex::fromString('aabbcc');
})->throws(InvalidColorValue::class);

it('cant be created from a string with a length too short', function () {
    Hex::fromString('#abbcc');
})->throws(InvalidColorValue::class);

it('cant be created from a string with a length too long', function () {
    Hex::fromString('#aabbccddee');
})->throws(InvalidColorValue::class);

it('cant be created from a string with invalid characters', function () {
    Hex::fromString('#ggbbcc');
})->throws(InvalidColorValue::class);

it('can be casted to a string', function () {
    $hex = new Hex('aa', 'bb', 'cc');

    assertSame('#aabbcc', (string) $hex);
});

it('can be casted to a string with alpha', function () {
    $hex = new Hex('aa', 'bb', 'cc', 'dd');

    assertSame('#aabbccdd', (string) $hex);
});

it('can be converted to CIELab', function () {
    $hex = new Hex('aa', 'bb', 'cc');
    $lab = $hex->toCIELab();

    assertSame(75.11, $lab->l());
    assertSame(-2.29, $lab->a());
    assertSame(-10.54, $lab->b());
});

it('can be converted to cmyk', function () {
    $hex = new Hex('aa', 'bb', 'cc');
    $cmyk = $hex->toCmyk();

    assertSame(170, $cmyk->red());
    assertSame(187, $cmyk->green());
    assertSame(204, $cmyk->blue());
});

it('can be converted from hex("00", "00", "00") to cmyk', function () {
    $hex = new Hex('00', '00', '00');
    $cmyk = $hex->toCmyk();

    assertSame(0, $cmyk->red());
    assertSame(0, $cmyk->green());
    assertSame(0, $cmyk->blue());
});

it('can be converted to hex', function () {
    $hex = new Hex('aa', 'bb', 'cc');
    $newHex = $hex->toHex();

    assertSame($hex->red(), $newHex->red());
    assertSame($hex->green(), $newHex->green());
    assertSame($hex->blue(), $newHex->blue());
    assertNotSame($hex, $newHex);
});

it('can be converted to hsl', function () {
    $hex = new Hex('aa', 'bb', 'cc');
    $hsl = $hex->toHsl();

    assertSame(170, $hsl->red());
    assertSame(187, $hsl->green());
    assertSame(204, $hsl->blue());
});

it('can be converted to hsl with same intensity', function () {
    $hex = new Hex('a8', 'a8', 'a8');
    $hsl = $hex->toHsl();

    assertSame(168, $hsl->red());
    assertSame(168, $hsl->green());
    assertSame(168, $hsl->blue());
});

it('can be converted to hsl with a with value', function () {
    $hex = new Hex('ff', 'ff', 'ff');
    $hsl = $hex->toHsl();

    assertSame(255, $hsl->red());
    assertSame(255, $hsl->green());
    assertSame(255, $hsl->blue());
});

it('can be converted to hsl with a black value', function () {
    $hex = new Hex('00', '00', '00');
    $hsl = $hex->toHsl();

    assertSame(0, $hsl->red());
    assertSame(0, $hsl->green());
    assertSame(0, $hsl->blue());
});

it('can be converted to hsla with a specific alpha value', function () {
    $hex = new Hex('aa', 'bb', 'cc');
    $hsla = $hex->toHsla(0.75);

    assertSame(170, $hsla->red());
    assertSame(187, $hsla->green());
    assertSame(204, $hsla->blue());
    assertSame(0.75, $hsla->alpha());
});

it('can be converted to rgb', function () {
    $hex = new Hex('aa', 'bb', 'cc');
    $rgb = $hex->toRgb();

    assertSame(170, $rgb->red());
    assertSame(187, $rgb->green());
    assertSame(204, $rgb->blue());
});

it('can be converted to rgba', function () {
    $hex = new Hex('aa', 'bb', 'cc');
    $rgba = $hex->toRgba(0.5);

    assertSame(170, $rgba->red());
    assertSame(187, $rgba->green());
    assertSame(204, $rgba->blue());
    assertSame(0.5, $rgba->alpha());
});

it('can be converted to xyz', function () {
    $hex = new Hex('aa', 'bb', 'cc');
    $xyz = $hex->toXyz();

    assertSame(45.2470, $xyz->x());
    assertSame(48.4463, $xyz->y());
    assertSame(64.0930, $xyz->z());
})->skip();
