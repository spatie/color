<?php

use Spatie\Color\Argb;
use Spatie\Color\Exceptions\InvalidColorValue;

it('is initializable', function () {
    $argb = new Argb(0.5, 55, 155, 255);

    expect($argb)->toBeInstanceOf(Argb::class)
        ->and($argb->alpha())->toBe(0.5)
        ->and($argb->red())->toBe(55)
        ->and($argb->green())->toBe(155)
        ->and($argb->blue())->toBe(255);
});

it('cant be initialized with a negative color value', function () {
    new Argb(0.5, -5, 255, 255);
})->throws(InvalidColorValue::class);

it('cant be initialized with a color value higher than 255', function () {
    new Argb(0.5, 300, 255, 255);
})->throws(InvalidColorValue::class);

it('cant be initialized with a negative alpha value', function () {
    new Argb(-1, 255, 255, 255);
})->throws(InvalidColorValue::class);

it('cant be initialized with an alpha value higher than 1', function () {
    new Argb(1.5, 255, 255, 255);
})->throws(InvalidColorValue::class);

it('can be created from a string', function () {
    $argb = Argb::fromString('argb(0.5,55,155,255)');

    expect($argb)->toBeInstanceOf(Argb::class)
        ->and($argb->alpha())->toBe(0.5)
        ->and($argb->red())->toBe(55)
        ->and($argb->green())->toBe(155)
        ->and($argb->blue())->toBe(255);
});

it('can be created with an opacity value without leading zero', function () {
    $argb = Argb::fromString('argb(.555,55,155,255)');

    expect($argb)->toBeInstanceOf(Argb::class)
        ->and($argb->alpha())->toBe(.555)
        ->and($argb->red())->toBe(55)
        ->and($argb->green())->toBe(155)
        ->and($argb->blue())->toBe(255);
});

it('can be created from a string with 3 decimals in opacity', function () {
    $argb = Argb::fromString('argb(0.555,55,155,255)');

    expect($argb)->toBeInstanceOf(Argb::class)
        ->and($argb->alpha())->toBe(0.555)
        ->and($argb->red())->toBe(55)
        ->and($argb->green())->toBe(155)
        ->and($argb->blue())->toBe(255);
});

it('can be created from a string with spaces', function () {
    $argb = Argb::fromString('  argb(  0.5  ,  55  ,  155  ,  255  )  ');

    expect($argb)->toBeInstanceOf(Argb::class)
        ->and($argb->alpha())->toBe(0.5)
        ->and($argb->red())->toBe(55)
        ->and($argb->green())->toBe(155)
        ->and($argb->blue())->toBe(255);
});

it('cant be created from malformed string', function () {
    Argb::fromString('argb(0.5,55,155,255');
})->throws(InvalidColorValue::class);

it('cant be created from a string with text around', function () {
    Argb::fromString('abc argb(0.5,55,155,255) abc');
})->throws(InvalidColorValue::class);

it('can be casted to a string', function () {
    $argb = new Argb(0.5, 55, 155, 255);

    expect((string) $argb)->toBe('argb(0.50,55,155,255)');
});

it('can be converted to CIELab', function () {
    $argb = new Argb(0.5, 55, 155, 255);
    $lab = $argb->toCIELab();

    expect($lab->l())->toBe(62.91)
        ->and($lab->a())->toBe(5.34)
        ->and($lab->b())->toBe(-57.73);
});

it('can be converted to cmyk', function () {
    $argb = new Argb(0.5, 55, 155, 255);
    $cmyk = $argb->toCmyk();

    expect($cmyk->red())->toBe($argb->red())
        ->and($cmyk->green())->toBe($argb->green())
        ->and($cmyk->blue())->toBe($argb->blue());
});

it('can be converted to argb', function () {
    $argb = new Argb(0.5, 55, 155, 255);
    $newArgb = $argb->toArgb();

    expect(serialize($newArgb))->toBe(serialize($argb));
});

it('can be converted to argb with a specific alpha value', function () {
    $argb = new Argb(0.5, 55, 155, 255);
    $newArgb = $argb->toArgb(0.7);

    expect($newArgb->alpha())->toBe(0.7)
        ->and($newArgb->red())->toBe(55)
        ->and($newArgb->green())->toBe(155)
        ->and($newArgb->blue())->toBe(255)
        ->and(serialize($newArgb))->not->toBe(serialize($argb));
});

it('can be converted to rgba', function () {
    $argb = new Argb(0.5, 55, 155, 255);
    $rgba = $argb->toRgba();

    expect($rgba->red())->toBe(55)
        ->and($rgba->green())->toBe(155)
        ->and($rgba->blue())->toBe(255)
        ->and($rgba->alpha())->toBe(0.5);
});

it('can be converted to rgb without an alpha value', function () {
    $argb = new Argb(0.5, 55, 155, 255);
    $rgb = $argb->toRgb();

    expect($rgb->red())->toBe(55)
        ->and($rgb->green())->toBe(155)
        ->and($rgb->blue())->toBe(255);
});

it('can be converted to hex', function () {
    $argb = new Argb(0.5, 55, 155, 255);
    $hex = $argb->toHex();

    expect($hex->red())->toBe('37')
        ->and($hex->green())->toBe('9b')
        ->and($hex->blue())->toBe('ff')
        ->and($hex->alpha())->toBe('80');
});

it('can be converted to hex with a specific alpha value', function () {
    $argb = new Argb(0.5, 55, 155, 255);
    $hex = $argb->toHex('dd');

    expect($hex->red())->toBe('37')
        ->and($hex->green())->toBe('9b')
        ->and($hex->blue())->toBe('ff')
        ->and($hex->alpha())->toBe('dd');
});

it('can be converted to hsl without an alpha value', function () {
    $argb = new Argb(0.5, 55, 155, 255);
    $hsl = $argb->toHsl();

    expect($hsl->red())->toBe(55)
        ->and($hsl->green())->toBe(155)
        ->and($hsl->blue())->toBe(255);
});

it('can be converted to hsla', function () {
    $argb = new Argb(0.5, 55, 155, 255);
    $hsla = $argb->toHsla();

    expect($hsla->red())->toBe(55)
        ->and($hsla->green())->toBe(155)
        ->and($hsla->blue())->toBe(255)
        ->and($hsla->alpha())->toBe(0.5);
});

it('can be converted to hsla with a specific alpha value', function () {
    $argb = new Argb(0.5, 55, 155, 255);
    $hsla = $argb->toHsla(0.75);

    expect($hsla->red())->toBe(55)
        ->and($hsla->green())->toBe(155)
        ->and($hsla->blue())->toBe(255)
        ->and($hsla->alpha())->toBe(0.75);
});

it('can be converted to xyz', function () {
    $argb = new Argb(0.5, 55, 155, 255);
    $xyz = $argb->toXyz();

    expect($xyz->x())->toBe(31.3469)
        ->and($xyz->y())->toBe(31.4749)
        ->and($xyz->z())->toBe(99.0308);
});
