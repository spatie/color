<?php

use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Hsla;

it('is initializable', function () {
    $hsla = new Hsla(55, 55, 67, 0.5);

    expect($hsla)->toBeInstanceOf(Hsla::class)
        ->and($hsla->hue())->toBe(55.0)
        ->and($hsla->saturation())->toBe(55.0)
        ->and($hsla->lightness())->toBe(67.0)
        ->and($hsla->alpha())->toBe(0.5);
});

it('cant be initialized with a negative saturation', function () {
    new Hsla(-5, -1, 67);
})->throws(InvalidColorValue::class);

it('cant be initialized with a saturation higher than 100', function () {
    new Hsla(-5, 108, 67);
})->throws(InvalidColorValue::class);

it('cant be initialized with a negative lightness', function () {
    new Hsla(-5, 55, -67);
})->throws(InvalidColorValue::class);

it('cant be initialized with a lightness higher than 100', function () {
    new Hsla(-5, 55, 102);
})->throws(InvalidColorValue::class);

it('cant be initialized with a negative alpha value', function () {
    new Hsla(255, 55, 25, -1);
})->throws(InvalidColorValue::class);

it('cant be initialized with an alpha value higher than 1', function () {
    new Hsla(255, 0.25, 55, 1.5);
})->throws(InvalidColorValue::class);

it('can be created from a string', function () {
    $hsla = Hsla::fromString('hsla(205,35%,17%,0.78)');

    expect($hsla)->toBeInstanceOf(Hsla::class)
        ->and($hsla->hue())->toBe(205.0)
        ->and($hsla->saturation())->toBe(35.0)
        ->and($hsla->lightness())->toBe(17.0)
        ->and($hsla->alpha())->toBe(0.78);
});

it('can be created from a string without percentages', function () {
    $hsla = Hsla::fromString('hsla(205,35,17,0.78)');

    expect($hsla)->toBeInstanceOf(Hsla::class)
        ->and($hsla->hue())->toBe(205.0)
        ->and($hsla->saturation())->toBe(35.0)
        ->and($hsla->lightness())->toBe(17.0)
        ->and($hsla->alpha())->toBe(0.78);
});

it('can be created from a string with spaces', function () {
    $hsla = Hsla::fromString('  hsla(  205  ,  35%  ,  17%  ,  0.89  )  ');

    expect($hsla)->toBeInstanceOf(Hsla::class)
        ->and($hsla->hue())->toBe(205.0)
        ->and($hsla->saturation())->toBe(35.0)
        ->and($hsla->lightness())->toBe(17.0)
        ->and($hsla->alpha())->toBe(0.89);
});

it('cant be created from malformed string', function () {
    Hsla::fromString('hsla(205,0.35,0.17,0.78');
})->throws(InvalidColorValue::class);

it('cant be created from a string with text around', function () {
    Hsla::fromString('abc hsla(205,0.35,0.17,0.78) abc');
})->throws(InvalidColorValue::class);

it('can be casted to a string', function () {
    $hsla = new Hsla(55, 15, 25, 0.4);

    expect((string) $hsla)->toBe('hsla(55,15%,25%,0.4)');
});

it('calculates rgb values', function (string $hslaString, int $red, int $green, int $blue) {
    $hsla = Hsla::fromString($hslaString);

    expect($hsla->red())->toBe($red)
        ->and($hsla->green())->toBe($green)
        ->and($hsla->blue())->toBe($blue);
})->with('hsla_string_and_rgb_values');

it('can be converted to CIELab', function () {
    $hsla = new Hsla(55, 15, 25, 0.4);
    $lab = $hsla->toCIELab();

    expect($lab->l())->toBe(30.20)
        ->and($lab->a())->toBe(-3.07)
        ->and($lab->b())->toBe(10.98);
});

it('can be converted to cmyk', function () {
    $hsla = new Hsla(55, 15, 25, 0.4);
    $cmyk = $hsla->toCmyk();

    expect($cmyk->red())->toBe($hsla->red())
        ->and($cmyk->green())->toBe($hsla->green())
        ->and($cmyk->blue())->toBe($hsla->blue());
});

it('can be converted to hsla', function () {
    $hsla = new Hsla(55, 55, 67, 0.5);
    $newHsla = $hsla->toHsla();

    expect(serialize($newHsla))->toBe(serialize($hsla));
});

it('can be converted to hsla with a specific alpha value', function () {
    $hsla = new Hsla(55, 55, 67);
    $newHsla = $hsla->toHsla(0.5);

    expect($newHsla->hue())->toBe($hsla->hue())
        ->and($newHsla->saturation())->toBe($hsla->saturation())
        ->and($newHsla->lightness())->toBe($hsla->lightness())
        ->and($newHsla->alpha())->toBe(0.5)
        ->and(serialize($newHsla))->not->toBe(serialize($hsla));
});

it('can be converted to hsl', function () {
    $hsla = new Hsla(55, 55, 67);
    $hsl = $hsla->toHsl();

    expect($hsl->hue())->toBe($hsla->hue())
        ->and($hsl->saturation())->toBe($hsla->saturation())
        ->and($hsl->lightness())->toBe($hsla->lightness());
});

it('can be converted to rgb', function () {
    $hsla = new Hsla(55, 55, 67);
    $rgb = $hsla->toRgb();

    expect($rgb->red())->toBe(217)
        ->and($rgb->green())->toBe(209)
        ->and($rgb->blue())->toBe(125);
});

it('can be converted to rgba', function () {
    $hsla = new Hsla(55, 55, 67, 0.6);
    $rgba = $hsla->toRgba();

    expect($rgba->red())->toBe(217)
        ->and($rgba->green())->toBe(209)
        ->and($rgba->blue())->toBe(125)
        ->and($rgba->alpha())->toBe(0.6);
});

it('can be converted to rgba with a specific alpha value', function () {
    $hsla = new Hsla(55, 55, 67);
    $rgba = $hsla->toRgba(0.5);

    expect($rgba->red())->toBe(217)
        ->and($rgba->green())->toBe(209)
        ->and($rgba->blue())->toBe(125)
        ->and($rgba->alpha())->toBe(0.5);
});

it('can be converted to hex', function () {
    $hsla = new Hsla(55, 55, 67, 0.5);
    $hex = $hsla->toHex();

    expect($hex->red())->toBe('d9')
        ->and($hex->green())->toBe('d1')
        ->and($hex->blue())->toBe('7d')
        ->and($hex->alpha())->toBe('80');
});

it('can be converted to hex with a specific alpha value', function () {
    $hsla = new Hsla(55, 55, 67, 0.5);
    $hex = $hsla->toHex('dd');

    expect($hex->red())->toBe('d9')
        ->and($hex->green())->toBe('d1')
        ->and($hex->blue())->toBe('7d')
        ->and($hex->alpha())->toBe('dd');
});

it('can be converted to xyz', function () {
    $hsla = new Hsla(55, 55, 67);
    $xyz = $hsla->toXyz();

    expect($xyz->x())->toBe(55.1174)
        ->and($xyz->y())->toBe(61.8333)
        ->and($xyz->z())->toBe(28.4321);
})->skip();
