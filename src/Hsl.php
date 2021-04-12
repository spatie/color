<?php

namespace Spatie\Color;

class Hsl implements Color
{
    /** @var float */
    protected $hue;
    protected $saturation;
    protected $lightness;

    public function __construct(float $hue, float $saturation, float $lightness)
    {
        Validate::hslValue($saturation, 'saturation');
        Validate::hslValue($lightness, 'lightness');

        $this->hue = $hue;
        $this->saturation = $saturation;
        $this->lightness = $lightness;
    }

    public static function fromString(string $string)
    {
        Validate::hslColorString($string);

        $matches = null;
        preg_match('/hsl\( *(-?\d{1,3}) *, *(\d{1,3})%? *, *(\d{1,3})%? *\)/i', $string, $matches);

        return new static($matches[1], $matches[2], $matches[3]);
    }

    public function hue(): float
    {
        return $this->hue;
    }

    public function saturation(): float
    {
        return $this->saturation;
    }

    public function lightness(): float
    {
        return $this->lightness;
    }

    public function red(): int
    {
        return Convert::hslValueToRgb($this->hue, $this->saturation, $this->lightness)[0];
    }

    public function green(): int
    {
        return Convert::hslValueToRgb($this->hue, $this->saturation, $this->lightness)[1];
    }

    public function blue(): int
    {
        return Convert::hslValueToRgb($this->hue, $this->saturation, $this->lightness)[2];
    }

    public function luminance(): float
    {
        $rgb = $this->toRgb();
        return Convert::rgbValueToLuminance($rgb->red(), $rgb->green(), $rgb->blue());
    }

    public function contrastRatio(): float
    {
        $luminance = $this->luminance() / 100;
        $black = new Rgb(0, 0, 0);
        $blackLuminance = $black->luminance() / 100;

        $contrastRatio = 0;
        if ($luminance > $blackLuminance) {
            $contrastRatio = (int) (($luminance + 0.05) / ($blackLuminance + 0.05));
        } else {
            $contrastRatio = (int) (($blackLuminance + 0.05) / ($luminance + 0.05));
        }

        return $contrastRatio;
    }

    public function toHex(): Hex
    {
        return new Hex(
            Convert::rgbChannelToHexChannel($this->red()),
            Convert::rgbChannelToHexChannel($this->green()),
            Convert::rgbChannelToHexChannel($this->blue())
        );
    }

    public function toHsl(): self
    {
        return new self($this->hue(), $this->saturation(), $this->lightness());
    }

    public function toHsla(float $alpha = 1): Hsla
    {
        return new Hsla($this->hue(), $this->saturation(), $this->lightness(), $alpha);
    }

    public function toRgb(): Rgb
    {
        return new Rgb($this->red(), $this->green(), $this->blue());
    }

    public function toRgba(float $alpha = 1): Rgba
    {
        return new Rgba($this->red(), $this->green(), $this->blue(), $alpha);
    }

    public function toLuminanceScale(
        array $scale = [
            50 => 93.0,
            100 => 86.0,
            200 => 74.0,
            300 => 59.0,
            400 => 39.0,
            500 => 24.0,
            600 => 15.0,
            700 => 11.5,
            800 => 7.0,
            900 => 3.0,
        ]
    ): array {
        $palette = [];
        foreach ($scale as $key => $luminance) {
            [$hue, $saturation, $lightness] = Convert::hslValueFromLuminance(
                $hsl->hue(),
                $hsl->saturation(),
                $luminance
            );
            $palette[$key] = new self($hue, $saturation, $lightness);
        }

        return $palette;
    }

    public function __toString(): string
    {
        $hue = round($this->hue);
        $saturation = round($this->saturation);
        $lightness = round($this->lightness);

        return "hsl({$hue},{$saturation}%,{$lightness}%)";
    }
}
