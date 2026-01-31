<?php

use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Rgba;

it('is initializable', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);

    expect($rgba)->toBeInstanceOf(Rgba::class)
        ->and($rgba->red())->toBe(55)
        ->and($rgba->green())->toBe(155)
        ->and($rgba->blue())->toBe(255)
        ->and($rgba->alpha())->toBe(0.5);
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

    expect($rgba)->toBeInstanceOf(Rgba::class)
        ->and($rgba->red())->toBe(55)
        ->and($rgba->green())->toBe(155)
        ->and($rgba->blue())->toBe(255)
        ->and($rgba->alpha())->toBe(0.5);
});

it('can be created with an opacity value without leading zero', function () {
    $rgba = Rgba::fromString('rgba(55,155,255,.555)');

    expect($rgba)->toBeInstanceOf(Rgba::class)
        ->and($rgba->red())->toBe(55)
        ->and($rgba->green())->toBe(155)
        ->and($rgba->blue())->toBe(255)
        ->and($rgba->alpha())->toBe(.555);
});

it('can be created from a string with 3 decimals in opacity', function () {
    $rgba = Rgba::fromString('rgba(55,155,255,0.555)');

    expect($rgba)->toBeInstanceOf(Rgba::class)
        ->and($rgba->red())->toBe(55)
        ->and($rgba->green())->toBe(155)
        ->and($rgba->blue())->toBe(255)
        ->and($rgba->alpha())->toBe(0.555);
});

it('can be created from a string with spaces', function () {
    $rgba = Rgba::fromString('  rgba(  55  ,  155  ,  255  ,  0.5  )  ');

    expect($rgba)->toBeInstanceOf(Rgba::class)
        ->and($rgba->red())->toBe(55)
        ->and($rgba->green())->toBe(155)
        ->and($rgba->blue())->toBe(255)
        ->and($rgba->alpha())->toBe(0.5);
});

it('cant be created from malformed string', function () {
    Rgba::fromString('rgba(55,155,255,0.5');
})->throws(InvalidColorValue::class);

it('cant be created from a string with text around', function () {
    Rgba::fromString('abc rgba(55,155,255,0.5) abc');
})->throws(InvalidColorValue::class);

it('can be casted to a string', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);

    expect((string) $rgba)->toBe('rgba(55,155,255,0.50)');
});

it('can be converted to CIELab', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);
    $lab = $rgba->toCIELab();

    expect($lab->l())->toBe(62.91)
        ->and($lab->a())->toBe(5.34)
        ->and($lab->b())->toBe(-57.73);
});

it('can be converted to cmyk', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);
    $cmyk = $rgba->toCmyk();

    expect($cmyk->red())->toBe($rgba->red())
        ->and($cmyk->green())->toBe($rgba->green())
        ->and($cmyk->blue())->toBe($rgba->blue());
});

it('can be converted to rgba', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);
    $newRgba = $rgba->toRgba();

    expect(serialize($newRgba))->toBe(serialize($rgba));
});

it('can be converted to rgba with with a specific alpha value', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);
    $newRgba = $rgba->toRgba(0.7);

    expect($newRgba->red())->toBe(55)
        ->and($newRgba->green())->toBe(155)
        ->and($newRgba->blue())->toBe(255)
        ->and($newRgba->alpha())->toBe(0.7)
        ->and(serialize($newRgba))->not->toBe(serialize($rgba));
});

it('can be converted to rgb without an alpha value', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);
    $rgb = $rgba->toRgb();

    expect($rgb->red())->toBe(55)
        ->and($rgb->green())->toBe(155)
        ->and($rgb->blue())->toBe(255);
});

it('can be converted to hex', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);
    $hex = $rgba->toHex();

    expect($hex->red())->toBe('37')
        ->and($hex->green())->toBe('9b')
        ->and($hex->blue())->toBe('ff')
        ->and($hex->alpha())->toBe('80');
});

it('can be converted to hex with a specific alpha value', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);
    $hex = $rgba->toHex('dd');

    expect($hex->red())->toBe('37')
        ->and($hex->green())->toBe('9b')
        ->and($hex->blue())->toBe('ff')
        ->and($hex->alpha())->toBe('dd');
});

it('can be converted to hsl without an alpha value', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);
    $hsl = $rgba->toHsl();

    expect($hsl->red())->toBe(55)
        ->and($hsl->green())->toBe(155)
        ->and($hsl->blue())->toBe(255);
});

it('can be converted to hsla', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);
    $hsla = $rgba->toHsla();

    expect($hsla->red())->toBe(55)
        ->and($hsla->green())->toBe(155)
        ->and($hsla->blue())->toBe(255)
        ->and($hsla->alpha())->toBe(0.5);
});

it('can be converted to hsla with a specific alpha value', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);
    $hsla = $rgba->toHsla(0.75);

    expect($hsla->red())->toBe(55)
        ->and($hsla->green())->toBe(155)
        ->and($hsla->blue())->toBe(255)
        ->and($hsla->alpha())->toBe(0.75);
});

it('can be converted to xyz', function () {
    $rgba = new Rgba(55, 155, 255, 0.5);
    $xyz = $rgba->toXyz();

    expect($xyz->x())->toBe(31.3469)
        ->and($xyz->y())->toBe(31.4749)
        ->and($xyz->z())->toBe(99.0308);
});
