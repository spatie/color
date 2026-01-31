<?php

use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Hsl;

it('is initializable', function () {
    $hsl = new Hsl(55, 55, 67);

    expect($hsl)->toBeInstanceOf(Hsl::class)
        ->and($hsl->hue())->toBe(55.0)
        ->and($hsl->saturation())->toBe(55.0)
        ->and($hsl->lightness())->toBe(67.0);
});

it('cant be initialized with a negative saturation', function () {
    new Hsl(-5, -1, 67);
})->throws(InvalidColorValue::class);

it('cant be initialized with a saturation higher than 100', function () {
    new Hsl(-5, 105, 67);
})->throws(InvalidColorValue::class);

it('cant be initialized with a negative lightness', function () {
    new Hsl(-5, 55, -67);
})->throws(InvalidColorValue::class);

it('cant be initialized with a lightness higher than 100', function () {
    new Hsl(-5, 55, 107);
})->throws(InvalidColorValue::class);

it('can be created from a string', function () {
    $hsl = Hsl::fromString('hsl(205,35%,17%)');

    expect($hsl)->toBeInstanceOf(Hsl::class)
        ->and($hsl->hue())->toBe(205.0)
        ->and($hsl->saturation())->toBe(35.0)
        ->and($hsl->lightness())->toBe(17.0);
});

it('can be created from a string without percentages', function () {
    $hsl = Hsl::fromString('hsl(205,35,17)');

    expect($hsl)->toBeInstanceOf(Hsl::class)
        ->and($hsl->hue())->toBe(205.0)
        ->and($hsl->saturation())->toBe(35.0)
        ->and($hsl->lightness())->toBe(17.0);
});

it('can be created from a string with spaces', function () {
    $hsl = Hsl::fromString('  hsl(  205  ,  35%  ,  17%  )  ');

    expect($hsl)->toBeInstanceOf(Hsl::class)
        ->and($hsl->hue())->toBe(205.0)
        ->and($hsl->saturation())->toBe(35.0)
        ->and($hsl->lightness())->toBe(17.0);
});

it('cant be created from malformed string', function () {
    Hsl::fromString('hsl(55,155,255');
})->throws(InvalidColorValue::class);

it('cant be created from a string with text around', function () {
    Hsl::fromString('abc hsl(55,155,255) abc');
})->throws(InvalidColorValue::class);

it('can be casted to a string', function () {
    $hsl = new Hsl(55, 15, 25);

    expect((string) $hsl)->toBe('hsl(55,15%,25%)');
});

it('calculates rgb values', function (string $hslString, int $red, int $green, int $blue) {
    $hsl = Hsl::fromString($hslString);

    expect($hsl->red())->toBe($red)
        ->and($hsl->green())->toBe($green)
        ->and($hsl->blue())->toBe($blue);
})->with('hsl_string_and_rgb_values');

it('can be converted to CIELab', function () {
    $hsl = new Hsl(55, 55, 67);
    $lab = $hsl->toCIELab();

    expect($lab->l())->toBe(82.82)
        ->and($lab->a())->toBe(-9.02)
        ->and($lab->b())->toBe(42.55);
});

it('can be converted to cmyk', function () {
    $hsl = new Hsl(55, 55, 67);
    $cmyk = $hsl->toCmyk();

    expect($cmyk->red())->toBe($hsl->red())
        ->and($cmyk->green())->toBe($hsl->green())
        ->and($cmyk->blue())->toBe($hsl->blue());
});

it('can be converted to hsl', function () {
    $hsl = new Hsl(55, 55, 67);
    $newHsl = $hsl->toHsl();

    expect($newHsl->hue())->toBe($hsl->hue())
        ->and($newHsl->saturation())->toBe($hsl->saturation())
        ->and($newHsl->lightness())->toBe($hsl->lightness())
        ->and($newHsl)->not->toBe($hsl);
});

it('can be converted to hsla with a specific alpha value', function () {
    $hsl = new Hsl(55, 55, 67);
    $hsla = $hsl->toHsla(0.5);

    expect($hsla->hue())->toBe(55.0)
        ->and($hsla->saturation())->toBe(55.0)
        ->and($hsla->lightness())->toBe(67.0)
        ->and($hsla->alpha())->toBe(0.5);
});

it('can be converted to rgb', function () {
    $hsl = new Hsl(55, 55, 67);
    $rgb = $hsl->toRgb();

    expect($rgb->red())->toBe(217)
        ->and($rgb->green())->toBe(209)
        ->and($rgb->blue())->toBe(125);
});

it('can be converted to rgba with a specific alpha value', function () {
    $hsl = new Hsl(55, 55, 67);
    $rgba = $hsl->toRgba(0.5);

    expect($rgba->red())->toBe(217)
        ->and($rgba->green())->toBe(209)
        ->and($rgba->blue())->toBe(125)
        ->and($rgba->alpha())->toBe(0.5);
});

it('can be converted to hex', function () {
    $hsl = new Hsl(55, 55, 67);
    $hex = $hsl->toHex();

    expect($hex->red())->toBe('d9')
        ->and($hex->green())->toBe('d1')
        ->and($hex->blue())->toBe('7d');
});

it('can be converted to xyz', function () {
    $hsl = new Hsl(55, 55, 67);
    $xyz = $hsl->toXyz();

    expect($xyz->x())->toBe(55.1174)
        ->and($xyz->y())->toBe(61.8333)
        ->and($xyz->z())->toBe(28.4321);
})->skip();
