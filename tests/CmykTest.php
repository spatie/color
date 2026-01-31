<?php

use Spatie\Color\Cmyk;
use Spatie\Color\Exceptions\InvalidColorValue;

it('is initializable', function () {
    $cmyk = new Cmyk(0.5, 0.3, 0.2, 0.1);

    expect($cmyk)->toBeInstanceOf(Cmyk::class)
        ->and($cmyk->cyan())->toBe(0.5)
        ->and($cmyk->magenta())->toBe(0.3)
        ->and($cmyk->yellow())->toBe(0.2)
        ->and($cmyk->black())->toBe(0.1);
});

it('cant be initialized with invalid cmyk ranges', function () {
    new Cmyk(1.0, 1.0, 1.0, 2);
})->throws(InvalidColorValue::class);

it('can be created from a string', function () {
    $cmyk = Cmyk::fromString('cmyk(100%,50%,10%,25%)');

    expect($cmyk)->toBeInstanceOf(Cmyk::class)
        ->and($cmyk->cyan())->toBe(1.0)
        ->and($cmyk->magenta())->toBe(0.5)
        ->and($cmyk->yellow())->toBe(0.1)
        ->and($cmyk->black())->toBe(0.25);
});

it('cant be created from malformed string', function () {
    Cmyk::fromString('cmyk(50%,30%,20%,10%');
})->throws(InvalidColorValue::class);

it('cant be created from a string with text around', function () {
    Cmyk::fromString('abc cmyk(50%,30%,20%,10%) abc');
})->throws(InvalidColorValue::class);

it('can be casted to a string', function () {
    $cmyk = new Cmyk(0.5, 0.3, 0.2, 0.1);

    expect((string) $cmyk)->toBe('cmyk(50%,30%,20%,10%)');
});

it('can be converted to CIELab', function () {
    $cmyk = new Cmyk(0.17, 0.08, 0, 0.2);
    $lab = $cmyk->toCIELab();

    expect($lab->l())->toBe(75.04)
        ->and($lab->a())->toBe(-2.61)
        ->and($lab->b())->toBe(-10.65);
});

it('can be converted to hex', function () {
    $cmyk = new Cmyk(0.17, 0.08, 0, 0.2);
    $hex = $cmyk->toHex();

    expect($hex->red())->toBe('a9')
        ->and($hex->green())->toBe('bb')
        ->and($hex->blue())->toBe('cc');
});

it('can be converted to hsl', function () {
    $cmyk = new Cmyk(0.17, 0.08, 0, 0.2);
    $hsl = $cmyk->toHsl();

    expect($hsl->red())->toBe($cmyk->red())
        ->and($hsl->green())->toBe($cmyk->green())
        ->and($hsl->blue())->toBe($cmyk->blue());
});

it('can be converted to hsla with a specific alpha value', function () {
    $cmyk = new Cmyk(0.17, 0.08, 0, 0.2);
    $hsla = $cmyk->toHsla(0.75);

    expect($hsla->red())->toBe($cmyk->red())
        ->and($hsla->green())->toBe($cmyk->green())
        ->and($hsla->blue())->toBe($cmyk->blue())
        ->and($hsla->alpha())->toBe(0.75);
});

it('can be converted to rgb', function () {
    $cmyk = new Cmyk(0.17, 0.08, 0, 0.2);
    $rgb = $cmyk->toRgb();

    expect($rgb->red())->toBe($cmyk->red())
        ->and($rgb->green())->toBe($cmyk->green())
        ->and($rgb->blue())->toBe($cmyk->blue());
});

it('can be converted to rgba', function () {
    $cmyk = new Cmyk(0.17, 0.08, 0, 0.2);
    $rgba = $cmyk->toRgba(0.5);

    expect($rgba->red())->toBe($cmyk->red())
        ->and($rgba->green())->toBe($cmyk->green())
        ->and($rgba->blue())->toBe($cmyk->blue())
        ->and($rgba->alpha())->toBe(0.5);
});

it('can be converted to xyz', function () {
    $cmyk = new Cmyk(0.17, 0.08, 0, 0.2);
    $xyz = $cmyk->toXyz();

    expect($xyz->red())->toBe($cmyk->red())
        ->and($xyz->green())->toBe($cmyk->green())
        ->and($xyz->blue())->toBe($cmyk->blue());
});
