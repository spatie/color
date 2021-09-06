# A little library to handle color conversions and comparisons

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/color.svg?style=flat-square)](https://packagist.org/packages/spatie/color)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/color/master.svg?style=flat-square)](https://travis-ci.org/spatie/color)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/color.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/color)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/color.svg?style=flat-square)](https://packagist.org/packages/spatie/color)
![Tests](https://github.com/spatie/color/workflows/Tests/badge.svg)

A little library to handle color conversions and comparisons. Currently supports rgb, rgba, hex, hsl, hsla, CIELab, and xyz color formats as well as CIE76, CIE94, and CIEDE2000 color comparison algorithms.

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

$hsl = $rgb->toHsl();
echo $hsl; // hsl(210,100%,100%)

$lab = $rgb->toCIELab();
echo $lab; // CIELab(62.91,5.34,-57.73)

$xyz = $rgb->toXyz();
echo $xyz; // xyz(31.3469,31.4749,99.0308)

$hex2 = Hex::fromString('#2d78c8');

$cie76_distance = Distance::CIE76($rgb, $hex2);
$cie76_distance = Distance::CIE76('rgba(55,155,255,1)', '#2d78c8'); // Outputs the same thing, Factory is built-in to all comparison functions
echo $cie76_distance; // 55.894680426674

$cie94_distance = Distance::CIE94($rgb, $hex2);
echo $cie94_distance; // 13.490919427908

$cie94_textiles_distance = Distance::CIE94($rgb, $hex2, 1); // Third parameter optionally sets the application type (0 = Graphic Arts [Default], 1 = Textiles)
echo $cie94_textiles_distance; // 7.0926538068477

$ciede2000_distance = Distance::CIEDE2000($rgb, $hex2);
echo $ciede2000_distance; // 12.711957696301
```

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/color.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/color)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/color
```

## Usage

The `Color` package contains a separate class per color format, which each implement a `Color` interface.

There are seven classes which implement the `Color` interface:

- `CIELab`
- `Hex`
- `Hsl`
- `Hsla`
- `Rgb`
- `Rgba`
- `Xyz`

### `interface Spatie\Color\Color`

#### `fromString(): Color`

Parses a color string and returns a `Color` implementation, depending on the format of the input string.

```php
Hex::fromString('#000000');
Rgba::fromString('rgba(255, 255, 255, 1)');
Hsla::fromString('hsla(360, 100%, 100%, 1)');
```

Throws an `InvalidColorValue` exception if the string can't be parsed.

> `Rgb`, `Rgba`, `Hsl` and `Hsla` strings are allowed to have spaces. `rgb(0,0,0)` is just as valid as `rgb(0, 0, 0)`.

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

#### `toHsl(): Hsl`

Convert a color to a `Hsl` color.

```php
Rgb::fromString('rgb(0, 0, 255)')->toHsl();
// `Hsl` instance; 'hsl(240, 100%, 50%)'
```

When coming from a color format that supports opacity, the opacity will simply be omitted.

```php
Rgba::fromString('rgba(0, 0, 255, .5)')->toHsl();
// `Hsl` instance; 'hsl(240, 100%, 50%)'
```

#### `toHsla(float $alpha = 1): Hsla`

Convert a color to a `Hsla` color.

```php
Rgb::fromString('rgb(0, 0, 255)')->toHsla();
// `Hsla` instance; 'hsla(240, 100%, 50%, 1.0)'
```

When coming from a color format that doesn't support opacity, it can be added by passing it to the `$alpha` parameter.

```php
Rgb::fromString('rgb(0, 0, 255)')->toHsla(.5);
// `Hsla` instance; 'hsla(240, 100%, 50%, 0.5)'
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
(string) Hsla::fromString('hsl(240, 100%, 50%)'); // 'hsl(240, 100%, 50%)'
(string) Hsla::fromString('hsla(240, 100%, 50%, 1.0)'); // 'hsla(240, 100%, 50%, 1.0)'
```

### `Factory::fromString(): Color`

With the `Factory` class, you can create a color instance from any string (it does an educated guess under the hood). If the string isn't a valid color string in any format, it throws an `InvalidColorValue` exception.

```php
Factory::fromString('rgb(0, 0, 255)'); // `Rgb` instance
Factory::fromString('#0000ff'); // `Hex` instance
Factory::fromString('hsl(240, 100%, 50%)'); // `Hsl` instance
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
