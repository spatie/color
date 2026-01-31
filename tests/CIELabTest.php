<?php

use Spatie\Color\CIELab;
use Spatie\Color\Exceptions\InvalidColorValue;

it('is initializable', function () {
    $lab = new CIELab(62.91, 5.34, -57.73);

    expect($lab)->toBeInstanceOf(CIELab::class)
        ->and($lab->l())->toBe(62.91)
        ->and($lab->a())->toBe(5.34)
        ->and($lab->b())->toBe(-57.73);
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

    expect($lab)->toBeInstanceOf(CIELab::class)
        ->and($lab->l())->toBe(62.91)
        ->and($lab->a())->toBe(5.34)
        ->and($lab->b())->toBe(-57.73);
});

it('can be created from a string with spaces', function () {
    $lab = CIELab::fromString('  CIELab(  62.91,  5.34,  -57.73  )  ');

    expect($lab)->toBeInstanceOf(CIELab::class)
        ->and($lab->l())->toBe(62.91)
        ->and($lab->a())->toBe(5.34)
        ->and($lab->b())->toBe(-57.73);
});

it('cant be created from malformed string', function () {
    CIELab::fromString('CIELab(62.91,5.34,-57.73');
})->throws(InvalidColorValue::class);

it('cant be created from a string with text around', function () {
    CIELab::fromString('abc CIELab(62.91,5.34,-57.73) abc');
})->throws(InvalidColorValue::class);

it('can be casted to a string', function () {
    $lab = new CIELab(62.91, 5.34, -57.73);

    expect((string) $lab)->toBe('CIELab(62.91,5.34,-57.73)');
});

it('can be converted to CIELab', function () {
    $lab = new CIELab(62.91, 5.34, -57.73);
    $newLab = $lab->toCIELab();

    expect($newLab->l())->toBe($lab->l())
        ->and($newLab->a())->toBe($lab->a())
        ->and($newLab->b())->toBe($lab->b())
        ->and($newLab)->not->toBe($lab);
});

it('can be converted to cmyk', function () {
    $lab = new CIELab(62.91, 5.34, -57.73);
    $cmyk = $lab->toCmyk();

    expect($cmyk->red())->toBe($lab->red())
        ->and($cmyk->green())->toBe($lab->green())
        ->and($cmyk->blue())->toBe($lab->blue());
});

it('can be converted to rgb', function () {
    $lab = new CIELab(62.91, 5.34, -57.73);
    $rgb = $lab->toRgb();

    expect($rgb->red())->toBe(55)
        ->and($rgb->green())->toBe(155)
        ->and($rgb->blue())->toBe(255);
});

it('can be converted to rgba with a specific alpha value', function () {
    $lab = new CIELab(62.91, 5.34, -57.73);
    $rgba = $lab->toRgba(0.5);

    expect($rgba->red())->toBe(55)
        ->and($rgba->green())->toBe(155)
        ->and($rgba->blue())->toBe(255)
        ->and($rgba->alpha())->toBe(0.5);
});

it('can be converted to hex', function () {
    $lab = new CIELab(62.91, 5.34, -57.73);
    $hex = $lab->toHex();

    expect($hex->red())->toBe('37')
        ->and($hex->green())->toBe('9b')
        ->and($hex->blue())->toBe('ff');
});

it('can be converted to hsl', function () {
    $lab = new CIELab(62.91, 5.34, -57.73);
    $hsl = $lab->toHsl();

    expect($hsl->red())->toBe(55)
        ->and($hsl->green())->toBe(155)
        ->and($hsl->blue())->toBe(255);
});

it('can be converted to hsla with a specific alpha value', function () {
    $lab = new CIELab(62.91, 5.34, -57.73);
    $hsla = $lab->toHsla(0.5);

    expect($hsla->red())->toBe(55)
        ->and($hsla->green())->toBe(155)
        ->and($hsla->blue())->toBe(255)
        ->and($hsla->alpha())->toBe(0.5);
});

it('can be converted to xyz', function () {
    $lab = new CIELab(62.91, 5.34, -57.73);
    $xyz = $lab->toXyz();

    expect($xyz->x())->toBe(31.3514)
        ->and($xyz->y())->toBe(31.4791)
        ->and($xyz->z())->toBe(99.0395);
});
