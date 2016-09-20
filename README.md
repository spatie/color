# A little library to deal with color conversions

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/color.svg?style=flat-square)](https://packagist.org/packages/spatie/color)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/color/master.svg?style=flat-square)](https://travis-ci.org/spatie/color)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/xxxxxxxxx.svg?style=flat-square)](https://insight.sensiolabs.com/projects/xxxxxxxxx)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/color.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/color)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/color.svg?style=flat-square)](https://packagist.org/packages/spatie/color)

A little library to deal with color conversions. Currently supports rgb, rgba and hex formats.

```php
$rgb = Rgb::fromString('rgb(55,155,255)');

echo $rgb->red(); // 55
echo $rgb->green(); // 155
echo $rgb->blue(); // 255

echo $rgb; // rgb(55,155,255)

$rgba = $rgb->toRgba(); // `Spatie\Color\Rgba`
$rgba->alpha(); // 100
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

The `Color` package contains a seperate class per color format.

### `Spatie\Color\Rgb`

Can be instantiated with integer values:

```php
$rgb = new Rgb(55, 155, 255);
```

Or can be created from a string:

```php
$rgb = Rgb::fromString('rgb(55,155,255)');
```

#### Channel methods

```php
$rgb = new Rgb(55, 155, 255);

$rgb->red(); // 55
$rgb->green(); // 155
$rgb->blue(); // 255
```

#### Conversion methods

```php
$rgb->toHex(); // `Spatie\Color\Hex`

$rgb->toRgba(); // `Spatie\Color\Rgba`
$rgb->toRgba(50); // `Spatie\Color\Rgba` with alpha 50
```

### `Spatie\Color\Rgba`

Can be instantiated with integer values:

```php
$rgba = new Rgba(55, 155, 255, 50);
```

Or can be created from a string:

```php
$rgba = Rgba::fromString('rgba(55,155,255,0.5)');
```

#### Channel methods

```php
$rgba = new Rgba(55, 155, 255, 50);

$rgba->red(); // 55
$rgba->green(); // 155
$rgba->blue(); // 255
$rgba->alpha(); // 50
```

#### Conversion methods

> When converting to a format that doesn't support alpha, the alpha channel will be ignored

```php
$rgba->toRgb(); // `Spatie\Color\Rgb`
$rgba->toHex(); // `Spatie\Color\Hex`
```

### `Spatie\Color\Hex`

Can be instantiated with string values:

```php
$hex = new Hex('aa', 'bb', 'cc');
```

Or can be created from a string:

```php
$hex = Hex::fromString('#aabbcc');
```

#### Channel methods

```php
$hex = new Hex('aa', 'bb', 'cc');

$hex->red(); // 'aa'
$hex->green(); // 'bb'
$hex->blue(); // 'cc'
```

#### Conversion methods

```php
$hex->toRgb(); // `Spatue\Color\Rgb`

$hex->toRgba(); // `Spatue\Color\Rgba`
$hex->toRgba(50); // `Spatie\Color\Rgba` with alpha 50
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
