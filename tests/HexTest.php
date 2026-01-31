<?php

use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Hex;

it('is initializable', function () {
    $hex = new Hex('aa', 'bb', 'cc');

    expect($hex)->toBeInstanceOf(Hex::class)
        ->and($hex->red())->toBe('aa')
        ->and($hex->green())->toBe('bb')
        ->and($hex->blue())->toBe('cc');
});

it('cant be initialized with invalid hex string lengths', function () {
    new Hex('a', 'bb', 'cc');
})->throws(InvalidColorValue::class);

it('cant be initialized with invalid hex characters', function () {
    new Hex('gg', 'bb', 'cc');
})->throws(InvalidColorValue::class);

it('can be created from a string', function () {
    $hex = Hex::fromString('#aabbcc');

    expect($hex)->toBeInstanceOf(Hex::class)
        ->and($hex->red())->toBe('aa')
        ->and($hex->green())->toBe('bb')
        ->and($hex->blue())->toBe('cc');
});

it('can be created from a short string', function () {
    $hex = Hex::fromString('#abc');

    expect($hex)->toBeInstanceOf(Hex::class)
        ->and($hex->red())->toBe('aa')
        ->and($hex->green())->toBe('bb')
        ->and($hex->blue())->toBe('cc');
});

it('can be created from a string with alpha', function () {
    $hex = Hex::fromString('#aabbccdd');

    expect($hex)->toBeInstanceOf(Hex::class)
        ->and($hex->red())->toBe('aa')
        ->and($hex->green())->toBe('bb')
        ->and($hex->blue())->toBe('cc')
        ->and($hex->alpha())->toBe('dd');
});

it('can be created from a short string alpha', function () {
    $hex = Hex::fromString('#abcd');

    expect($hex)->toBeInstanceOf(Hex::class)
        ->and($hex->red())->toBe('aa')
        ->and($hex->green())->toBe('bb')
        ->and($hex->blue())->toBe('cc')
        ->and($hex->alpha())->toBe('dd');
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

    expect((string) $hex)->toBe('#aabbcc');
});

it('can be casted to a string with alpha', function () {
    $hex = new Hex('aa', 'bb', 'cc', 'dd');

    expect((string) $hex)->toBe('#aabbccdd');
});

it('can be converted to CIELab', function () {
    $hex = new Hex('aa', 'bb', 'cc');
    $lab = $hex->toCIELab();

    expect($lab->l())->toBe(75.11)
        ->and($lab->a())->toBe(-2.29)
        ->and($lab->b())->toBe(-10.54);
});

it('can be converted to cmyk', function () {
    $hex = new Hex('aa', 'bb', 'cc');
    $cmyk = $hex->toCmyk();

    expect($cmyk->red())->toBe(170)
        ->and($cmyk->green())->toBe(187)
        ->and($cmyk->blue())->toBe(204);
});

it('can be converted from hex("00", "00", "00") to cmyk', function () {
    $hex = new Hex('00', '00', '00');
    $cmyk = $hex->toCmyk();

    expect($cmyk->red())->toBe(0)
        ->and($cmyk->green())->toBe(0)
        ->and($cmyk->blue())->toBe(0);
});

it('can be converted to hex', function () {
    $hex = new Hex('aa', 'bb', 'cc', 'dd');
    $newHex = $hex->toHex();

    expect(serialize($hex))->toBe(serialize($newHex));
});

it('can be converted to hex with a specific alpha value', function () {
    $hex = new Hex('aa', 'bb', 'cc');
    $newHex = $hex->toHex('dd');

    expect($newHex->red())->toBe($hex->red())
        ->and($newHex->green())->toBe($hex->green())
        ->and($newHex->blue())->toBe($hex->blue())
        ->and(serialize($hex))->not->toBe(serialize($newHex));
});

it('can be converted to hsl', function () {
    $hex = new Hex('aa', 'bb', 'cc');
    $hsl = $hex->toHsl();

    expect($hsl->red())->toBe(170)
        ->and($hsl->green())->toBe(187)
        ->and($hsl->blue())->toBe(204);
});

it('can be converted to hsl with same intensity', function () {
    $hex = new Hex('a8', 'a8', 'a8');
    $hsl = $hex->toHsl();

    expect($hsl->red())->toBe(168)
        ->and($hsl->green())->toBe(168)
        ->and($hsl->blue())->toBe(168);
});

it('can be converted to hsl with a with value', function () {
    $hex = new Hex('ff', 'ff', 'ff');
    $hsl = $hex->toHsl();

    expect($hsl->red())->toBe(255)
        ->and($hsl->green())->toBe(255)
        ->and($hsl->blue())->toBe(255);
});

it('can be converted to hsl with a black value', function () {
    $hex = new Hex('00', '00', '00');
    $hsl = $hex->toHsl();

    expect($hsl->red())->toBe(0)
        ->and($hsl->green())->toBe(0)
        ->and($hsl->blue())->toBe(0);
});

it('can be converted to hsla', function () {
    $hex = new Hex('aa', 'bb', 'cc', 'dd');
    $hsla = $hex->toHsla();

    expect($hsla->red())->toBe(170)
        ->and($hsla->green())->toBe(187)
        ->and($hsla->blue())->toBe(204)
        ->and($hsla->alpha())->toBe(0.87);
});

it('can be converted to hsla with a specific alpha value', function () {
    $hex = new Hex('aa', 'bb', 'cc');
    $hsla = $hex->toHsla(0.75);

    expect($hsla->red())->toBe(170)
        ->and($hsla->green())->toBe(187)
        ->and($hsla->blue())->toBe(204)
        ->and($hsla->alpha())->toBe(0.75);
});

it('can be converted to rgb', function () {
    $hex = new Hex('aa', 'bb', 'cc');
    $rgb = $hex->toRgb();

    expect($rgb->red())->toBe(170)
        ->and($rgb->green())->toBe(187)
        ->and($rgb->blue())->toBe(204);
});

it('can be converted to rgba', function () {
    $hex = new Hex('aa', 'bb', 'cc', 'dd');
    $rgba = $hex->toRgba();

    expect($rgba->red())->toBe(170)
        ->and($rgba->green())->toBe(187)
        ->and($rgba->blue())->toBe(204)
        ->and($rgba->alpha())->toBe(0.87);
});

it('can be converted to rgba with a specific alpha value', function () {
    $hex = new Hex('aa', 'bb', 'cc');
    $rgba = $hex->toRgba(0.5);

    expect($rgba->red())->toBe(170)
        ->and($rgba->green())->toBe(187)
        ->and($rgba->blue())->toBe(204)
        ->and($rgba->alpha())->toBe(0.5);
});

it('can be converted to xyz', function () {
    $hex = new Hex('aa', 'bb', 'cc');
    $xyz = $hex->toXyz();

    expect($xyz->x())->toBe(45.2470)
        ->and($xyz->y())->toBe(48.4463)
        ->and($xyz->z())->toBe(64.0930);
})->skip();
