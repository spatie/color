<?php

use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Named;

it('is initializable', function () {
    $named = new Named('peru');

    expect($named)->toBeInstanceOf(Named::class)
        ->and($named->red())->toBe(205)
        ->and($named->green())->toBe(133)
        ->and($named->blue())->toBe(63)
        ->and((string) $named->toHex())->toBe('#cd853f');
});

it('is initializable with case-insensitive', function () {
    $named = new Named('PeRu');

    expect($named)->toBeInstanceOf(Named::class)
        ->and($named->red())->toBe(205)
        ->and($named->green())->toBe(133)
        ->and($named->blue())->toBe(63);
});

it('cant be initialized with unrecognized name', function () {
    new Named('wow');
})->throws(InvalidColorValue::class);

it('cant be created from malformed string', function () {
    Named::fromString('pe ru');
})->throws(InvalidColorValue::class);

it('can be casted to a string', function () {
    $named = new Named('peru');

    expect((string) $named)->toBe('peru');
});
