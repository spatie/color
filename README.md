# A little library to handle color conversions

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/color.svg?style=flat-square)](https://packagist.org/packages/spatie/color)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/color/master.svg?style=flat-square)](https://travis-ci.org/spatie/color)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/966ee426-e15b-4b9c-8676-a6c107bcabff.svg?style=flat-square)](https://insight.sensiolabs.com/projects/966ee426-e15b-4b9c-8676-a6c107bcabff)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/color.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/color)
[![StyleCI](https://styleci.io/repos/68709937/shield?branch=master)](https://styleci.io/repos/68709937)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/color.svg?style=flat-square)](https://packagist.org/packages/spatie/color)

A little library to handle color conversions. Currently supports rgb, rgba and hex formats.

```php
$rgb = Rgb::fromString('rgb(55,155,255)');

echo $rgb->red(); // 55
echo $rgb->green(); // 155
echo $rgb->blue(); // 255

echo $rgb; // rgb(55,155,255)

$rgba = $rgb->toRgba(); // `Spatie\Color\Rgba`
$rgba->alpha(); // 1
echo $rgba; // rgba(55,155,255,1)

$hex = $rgb->toHex(); // `Spatie\Color\Hex`
echo $hex; // #379bff
```

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## Postcardware

You're free to use this package (it's [MIT-licensed](LICENSE.md)), but if it makes it to your production environment you are required to send us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

The best postcards will get published on the open source page on our website.

## Installation

You can install the package via composer:

```bash
composer require spatie/color
```

## Usage

The `Color` package contains a seperate class per color format, which each implement a `Color` interface.

### `interface Spatie\Color\Color`

#### `fromString(): Color`

Parses a color string and returns a `Color` implementation, depending on the format of the input string.

```php
Hex::fromString('#000000');
Rgba::fromString('rgba(255, 255, 255, 1)');
```

Throws an `InvalidColorValue` exception if the string can't be parsed.

> `Rgb` and `Rgba` strings are allowed to have spaces. `rgb(0,0,0)` is just as valid as `rgb(0, 0, 0)`.

#### `red(): int|string`

Return the value of the `red` color channel.

```php
Hex::fromString('#ff0000')->red(); // 'ff'
Rgb::fromString('rgb(255, 0, 0)')->red(); // 255
```

#### `green(): int|string`

Return the value of the `green` color channel.

```php
Hex::fromString('#00ff00')->green(); // 'ff'
Rgb::fromString('rgb(0, 255, 0)')->green(); // 255
```

#### `blue(): int|string`

Return the value of the `blue` color channel.

```php
Hex::fromString('#0000ff')->blue(); // 'ff'
Rgb::fromString('rgb(0, 0, 255)')->blue(); // 255
```

#### `toHex(): Hex`

Convert a color to a `Hex` color.

```php
Rgb::fromString('rgb(0, 0, 255)')->toHex();
// `Hex` instance; '#0000ff'
```

When coming from a color format that supports opacity, the opacity will simply be omitted.

```php
Rgba::fromString('rgba(0, 0, 255, .5)')->toHex();
// `Hex` instance; '#0000ff'
```

#### `toRgb(): Rgb`

Convert a color to an `Rgb` color.

```php
Hex::fromString('#0000ff')->toRgb();
// `Rgb` instance; 'rgb(0, 0, 255)'
```

When coming from a color format that supports opacity, the opacity will simply be omitted.

```php
Rgba::fromString('rgb(0, 0, 255, .5)')->toRgb();
// `Rgb` instance; 'rgb(0, 0, 255)'
```

#### `toRgba(float $alpha = 1): Rgba`

Convert a color to a `Rgba` color.

```php
Rgb::fromString('rgb(0, 0, 255)')->toRgba();
// `Rgba` instance; 'rgba(0, 0, 255, 1)'
```

When coming from a color format that doesn't support opacity, it can be added by passing it to the `$alpha` parameter.

```php
Rgba::fromString('rgb(0, 0, 255)')->toRgba(.5);
// `Rgba` instance; 'rgba(0, 0, 255, .5)'
```

#### `__toString(): string`

Cast the color to a string.

```php
(string) Rgb::fromString('rgb(0, 0, 255)'); // 'rgb(0,0,255)'
(string) Rgba::fromString('rgb(0, 0, 255, .5)'); // 'rgb(0,0,255,0.5)'
(string) Hex::fromString('#0000ff'); // '#0000ff'
```

### `Factory::fromString(): Color`

With the `Factory` class, you can create a color instance from any string (it does an educated guess under the hood). If the string isn't a valid color string in any format, it throws an `InvalidColorValue` exception.

```php
Factory::fromString('rgb(0, 0, 255)'); // `Rgb` instance
Factory::fromString('#0000ff'); // `Hex` instance
Factory::fromString('Hello world!'); // `InvalidColorValue` exception
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [All Contributors](../../contributors)

## About Spatie
Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
