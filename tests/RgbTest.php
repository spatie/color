<?php

use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Rgb;

it('is initializable', function () {
    $rgb = new Rgb(55, 155, 255);

    expect($rgb)->toBeInstanceOf(Rgb::class)
        ->and($rgb->red())->toBe(55)
        ->and($rgb->green())->toBe(155)
        ->and($rgb->blue())->toBe(255);
});

it('cant be initialized with a negative color value', function () {
    new Rgb(-5, 255, 255);
})->throws(InvalidColorValue::class);

it('cant be initialized with a color value higher than 255', function () {
    new Rgb(300, 255, 255);
})->throws(InvalidColorValue::class);

it('can be created from a string', function () {
    $rgb = Rgb::fromString('rgb(55,155,255)');

    expect($rgb)->toBeInstanceOf(Rgb::class)
        ->and($rgb->red())->toBe(55)
        ->and($rgb->green())->toBe(155)
        ->and($rgb->blue())->toBe(255);
});

it('can be created from a string with spaces', function () {
    $rgb = Rgb::fromString('  rgb(  55  ,  155  ,  255  )  ');

    expect($rgb)->toBeInstanceOf(Rgb::class)
        ->and($rgb->red())->toBe(55)
        ->and($rgb->green())->toBe(155)
        ->and($rgb->blue())->toBe(255);
});

it('cant be created from malformed string', function () {
    Rgb::fromString('rgb(55,155,255');
})->throws(InvalidColorValue::class);

it('cant be created from a string with text around', function () {
    Rgb::fromString('abc rgb(55,155,255) abc');
})->throws(InvalidColorValue::class);

it('can be casted to a string', function () {
    $rgb = new Rgb(55, 155, 255);

    expect((string) $rgb)->toBe('rgb(55,155,255)');
});

it('can be converted to CIELab', function () {
    $rgb = new Rgb(55, 155, 255);
    $lab = $rgb->toCIELab();

    expect($lab->l())->toBe(62.91)
        ->and($lab->a())->toBe(5.34)
        ->and($lab->b())->toBe(-57.73);
});

it('can be converted to cmyk', function () {
    $rgb = new Rgb(55, 155, 255);
    $cmyk = $rgb->toCmyk();

    expect($cmyk->red())->toBe($rgb->red())
        ->and($cmyk->green())->toBe($rgb->green())
        ->and($cmyk->blue())->toBe($rgb->blue());
});

it('can be converted to rgb', function () {
    $rgb = new Rgb(55, 155, 255);
    $newRgb = $rgb->toRgb();

    expect($newRgb->red())->toBe($rgb->red())
        ->and($newRgb->green())->toBe($rgb->green())
        ->and($newRgb->blue())->toBe($rgb->blue())
        ->and($newRgb)->not->toBe($rgb);
});

it('can be converted from rgb(0,0,0) to cmyk', function () {
    $rgb = new Rgb(0, 0, 0);
    $cmyk = $rgb->toCmyk();

    expect($cmyk->red())->toBe($rgb->red())
        ->and($cmyk->green())->toBe($rgb->green())
        ->and($cmyk->blue())->toBe($rgb->blue());
});

it('can be converted to rgba with a specific alpha value', function () {
    $rgb = new Rgb(55, 155, 255);
    $rgba = $rgb->toRgba(0.5);

    expect($rgba->red())->toBe(55)
        ->and($rgba->green())->toBe(155)
        ->and($rgba->blue())->toBe(255)
        ->and($rgba->alpha())->toBe(0.5);
});

it('can be converted to hex', function () {
    $rgb = new Rgb(55, 155, 255);
    $hex = $rgb->toHex();

    expect($hex->red())->toBe('37')
        ->and($hex->green())->toBe('9b')
        ->and($hex->blue())->toBe('ff');
});

it('can be converted to hsb', function () {
    $rgb = new Rgb(128, 102, 102);
    $hsb = $rgb->toHsb();

    expect($hsb->hue())->toBe(0.0)
        ->and($hsb->saturation())->toBe(20.0)
        ->and($hsb->brightness())->toBe(50.0);
});

it('can be converted to hsl', function () {
    $rgb = new Rgb(55, 155, 255);
    $hsl = $rgb->toHsl();

    expect($hsl->red())->toBe(55)
        ->and($hsl->green())->toBe(155)
        ->and($hsl->blue())->toBe(255);
});

it('can be converted to hsla with a specific alpha value', function () {
    $rgb = new Rgb(55, 155, 255);
    $hsla = $rgb->toHsla(0.5);

    expect($hsla->red())->toBe(55)
        ->and($hsla->green())->toBe(155)
        ->and($hsla->blue())->toBe(255)
        ->and($hsla->alpha())->toBe(0.5);
});

it('can be converted to xyz', function () {
    $rgb = new Rgb(55, 155, 255);
    $xyz = $rgb->toXyz();

    expect($xyz->x())->toBe(31.3469)
        ->and($xyz->y())->toBe(31.4749)
        ->and($xyz->z())->toBe(99.0308);
})->skip();
