# Changelog

All Notable changes to `color` will be documented in this file

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
