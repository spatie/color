<?php

use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Xyz;

it('is initializable', function () {
    $xyz = new Xyz(31.3469, 31.4749, 99.0308);

    expect($xyz)->toBeInstanceOf(Xyz::class)
        ->and($xyz->x())->toBe(31.3469)
        ->and($xyz->y())->toBe(31.4749)
        ->and($xyz->z())->toBe(99.0308);
});

it('cant be initialized with a negative x value', function () {
    new Xyz(-5.00, 31.4749, 99.0308);
})->throws(InvalidColorValue::class);

it('cant be initialized with an x value higher than 95 047', function () {
    new Xyz(100.00, 31.4749, 99.0308);
})->throws(InvalidColorValue::class);

it('cant be initialized with a negative y value', function () {
    new Xyz(31.3469, -5.00, 99.0308);
})->throws(InvalidColorValue::class);

it('cant be initialized with a y value higher than 100', function () {
    new Xyz(31.3469, 150.00, 99.0308);
})->throws(InvalidColorValue::class);

it('cant be initialized with a negative z value', function () {
    new Xyz(31.3469, 31.4749, -5.00);
})->throws(InvalidColorValue::class);

it('cant be initialized with a z value higher than 108 883', function () {
    new Xyz(31.3469, 31.4749, 150.00);
})->throws(InvalidColorValue::class);

it('can be created from a string', function () {
    $xyz = Xyz::fromString('xyz(31.3469,31.4749,99.0308)');

    expect($xyz)->toBeInstanceOf(Xyz::class)
        ->and($xyz->x())->toBe(31.3469)
        ->and($xyz->y())->toBe(31.4749)
        ->and($xyz->z())->toBe(99.0308);
});

it('can be created from a string with spaces', function () {
    $xyz = Xyz::fromString('  xyz(  31.3469  ,  31.4749  ,  99.0308  )  ');

    expect($xyz)->toBeInstanceOf(Xyz::class)
        ->and($xyz->x())->toBe(31.3469)
        ->and($xyz->y())->toBe(31.4749)
        ->and($xyz->z())->toBe(99.0308);
});

it('cant be created from malformed string', function () {
    Xyz::fromString('xyz(31.3469,31.4749,99.0308');
})->throws(InvalidColorValue::class);

it('cant be created from a string with text around', function () {
    Xyz::fromString('abc xyz(31.3469,31.4749,99.0308) abc');
})->throws(InvalidColorValue::class);

it('can be casted to a string', function () {
    $xyz = new Xyz(31.3469, 31.4749, 99.0308);

    expect((string) $xyz)->toBe('xyz(31.3469,31.4749,99.0308)');
});

it('can be converted to CIELab', function () {
    $xyz = new Xyz(31.3469, 31.4749, 99.0308);
    $lab = $xyz->toCIELab();

    expect($lab->l())->toBe(62.91)
        ->and($lab->a())->toBe(5.34)
        ->and($lab->b())->toBe(-57.73);
});

it('can be converted to cmyk', function () {
    $xyz = new Xyz(31.3469, 31.4749, 99.0308);
    $cmyk = $xyz->toCmyk();

    expect($cmyk->red())->toBe($xyz->red())
        ->and($cmyk->green())->toBe($xyz->green())
        ->and($cmyk->blue())->toBe($xyz->blue());
});

it('can be converted to rgb', function () {
    $xyz = new Xyz(31.3469, 31.4749, 99.0308);
    $rgb = $xyz->toRgb();

    expect($rgb->red())->toBe(55)
        ->and($rgb->green())->toBe(155)
        ->and($rgb->blue())->toBe(255);
});

it('can be converted to rgba with a specific alpha value', function () {
    $xyz = new Xyz(31.3469, 31.4749, 99.0308);
    $rgba = $xyz->toRgba(0.5);

    expect($rgba->red())->toBe(55)
        ->and($rgba->green())->toBe(155)
        ->and($rgba->blue())->toBe(255)
        ->and($rgba->alpha())->toBe(0.5);
});

it('can be converted to hex', function () {
    $xyz = new Xyz(31.3469, 31.4749, 99.0308);
    $hex = $xyz->toHex();

    expect($hex->red())->toBe('37')
        ->and($hex->green())->toBe('9b')
        ->and($hex->blue())->toBe('ff');
});

it('can be converted to hsl', function () {
    $xyz = new Xyz(31.3469, 31.4749, 99.0308);
    $hsl = $xyz->toHsl();

    expect($hsl->red())->toBe(55)
        ->and($hsl->green())->toBe(155)
        ->and($hsl->blue())->toBe(255);
});

it('can be converted to hsla with a specific alpha value', function () {
    $xyz = new Xyz(31.3469, 31.4749, 99.0308);
    $hsla = $xyz->toHsla(0.5);

    expect($hsla->red())->toBe(55)
        ->and($hsla->green())->toBe(155)
        ->and($hsla->blue())->toBe(255)
        ->and($hsla->alpha())->toBe(0.5);
});

it('can be converted to xyz', function () {
    $xyz = new Xyz(31.3469, 31.4749, 99.0308);
    $newXyz = $xyz->toXyz();

    expect($newXyz->x())->toBe($xyz->x())
        ->and($newXyz->y())->toBe($xyz->y())
        ->and($newXyz->z())->toBe($xyz->z())
        ->and($newXyz)->not->toBe($xyz);
});
