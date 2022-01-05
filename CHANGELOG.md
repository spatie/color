# Changelog

All notable changes to `color` will be documented in this file

## 1.4.0 - 2022-01-05

- Added support for PHP 8
- Added support for CMYK & HSB
- Added support for HEX alpha channel
- Added support for 3-digit HEX values

## 1.3.1 - 2021-09-09

- Fix HEX/HSL conversion bug

## 1.3.0 - 2021-09-06
- Added CIELab and XYZ color formats and `Distance` API
- Added `Contrast` API

## 1.2.4 - 2021-02-18
- Fixed division by zero error on pure white/black convertions ([#42](https://github.com/spatie/color/pull/42))

## 1.2.3 - 2020-12-10
- Added support for PHP 8

## 1.2.2 - 2020-11-18
- Fix transform RGB value to HSL : division by zero (#38)

## 1.2.1 - 2020-07-17
- HSL to RGB fixes

## 1.2.0 - 2020-06-22
- Added HSL & HSLA support

## 1.1.1 - 2017-02-03
- Fixed validation when a color contained redundant characters at the beginning or end of the string

## 1.1.0 - 2017-01-13

- All color formats now implement a `Color` interface
- Added a `Factory` class with a `fromString` static method to guess a format
- `rgb` and `rgba` values can now contain spaces (e.g. `rgb(255, 255, 255)`)

## 1.0.2 - 2016-10-17

- `rgbChannelToHexChannel` now also accepts single single-digit hex values

## 1.0.1 - 2016-09-22

- Bugfix (breaking!): Alpha channel values are now a float between 0 and 1

## 1.0.0 - 2016-09-21

- First release
