<?php

use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Hsb;

it('is initializable', function () {
    $hsb = new Hsb(55, 55, 67);

    expect($hsb)->toBeInstanceOf(Hsb::class)
        ->and($hsb->hue())->toBe(55.0)
        ->and($hsb->saturation())->toBe(55.0)
        ->and($hsb->brightness())->toBe(67.0);
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

    expect($hsb)->toBeInstanceOf(Hsb::class)
        ->and($hsb->hue())->toBe(205.0)
        ->and($hsb->saturation())->toBe(35.0)
        ->and($hsb->brightness())->toBe(17.0);
});

it('can be created from a string without percentages', function () {
    $hsb = Hsb::fromString('hsb(205,35,17)');

    expect($hsb)->toBeInstanceOf(Hsb::class)
        ->and($hsb->hue())->toBe(205.0)
        ->and($hsb->saturation())->toBe(35.0)
        ->and($hsb->brightness())->toBe(17.0);
});

it('can be created from a string with spaces', function () {
    $hsb = Hsb::fromString('  hsb(  205  ,  35%  ,  17%  )  ');

    expect($hsb)->toBeInstanceOf(Hsb::class)
        ->and($hsb->hue())->toBe(205.0)
        ->and($hsb->saturation())->toBe(35.0)
        ->and($hsb->brightness())->toBe(17.0);
});

it('cant be created from malformed string', function () {
    Hsb::fromString('hsb(55,155,255');
})->throws(InvalidColorValue::class);

it('cant be created from a string with text around', function () {
    Hsb::fromString('abc hsb(55,155,255) abc');
})->throws(InvalidColorValue::class);

it('can be casted to a string', function () {
    $hsb = new Hsb(55, 15, 25);

    expect((string) $hsb)->toBe('hsb(55,15%,25%)');
});

it('can be converted to CIELab', function () {
    $hsb = new Hsb(50, 50, 50);
    $lab = $hsb->toCIELab();

    expect($lab->l())->toBe(49.11)
        ->and($lab->a())->toBe(-3.48)
        ->and($lab->b())->toBe(30.6);
});

it('can be converted to cmyk', function () {
    $hsb = new Hsb(55, 55, 67);
    $cmyk = $hsb->toCmyk();

    expect($cmyk->red())->toBe($hsb->red())
        ->and($cmyk->green())->toBe($hsb->green())
        ->and($cmyk->blue())->toBe($hsb->blue());
});

it('can be converted to rgb', function () {
    $hsb = new Hsb(50, 50, 50);
    $rgb = $hsb->toRgb();

    expect($rgb->red())->toBe(128)
        ->and($rgb->green())->toBe(117)
        ->and($rgb->blue())->toBe(64);
});

it('can be converted to rgba with a specific alpha value', function () {
    $hsb = new Hsb(50, 50, 50);
    $rgba = $hsb->toRgba(0.5);

    expect($rgba->red())->toBe(128)
        ->and($rgba->green())->toBe(117)
        ->and($rgba->blue())->toBe(64)
        ->and($rgba->alpha())->toBe(0.5);
});

it('can be converted to hex', function () {
    $hsb = new Hsb(50, 50, 50);
    $hex = $hsb->toHex();

    expect($hex->red())->toBe('80')
        ->and($hex->green())->toBe('75')
        ->and($hex->blue())->toBe('40');
});

it('can be converted to xyz', function () {
    $hsb = new Hsb(55, 55, 67);
    $xyz = $hsb->toXyz();

    expect($xyz->x())->toBe(55.1174)
        ->and($xyz->y())->toBe(61.8333)
        ->and($xyz->z())->toBe(28.4321);
})->skip();
