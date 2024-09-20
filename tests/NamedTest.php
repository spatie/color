<?php

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Named;

it('is initializable', function () {
    $named = new Named('peru');

    assertInstanceOf(Named::class, $named);
    assertSame(205, $named->red());
    assertSame(133, $named->green());
    assertSame(63, $named->blue());

    assertSame('#cd853f', (string) $named->toHex());
});

it('is initializable with case-insensitive', function () {
    $named = new Named('PeRu');

    assertInstanceOf(Named::class, $named);
    assertSame(205, $named->red());
    assertSame(133, $named->green());
    assertSame(63, $named->blue());
});

it('cant be initialized with unrecognized name', function () {
    new Named('wow');
})->throws(InvalidColorValue::class);

it('cant be created from malformed string', function () {
    Named::fromString('pe ru');
})->throws(InvalidColorValue::class);

it('can be casted to a string', function () {
    $named = new Named('peru');

    assertSame('peru', (string) $named);
});
