<?php

namespace Spatie\Color\Test;

use PHPUnit\Framework\TestCase;
use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Hsla;

class HslaTest extends TestCase
{
    /** @test */
    public function it_is_initializable()
    {
        $hsla = new Hsla(55, 55, 67, 0.5);

        $this->assertInstanceOf(Hsla::class, $hsla);
        $this->assertSame(55.0, $hsla->hue());
        $this->assertSame(55.0, $hsla->saturation());
        $this->assertSame(67.0, $hsla->lightness());
        $this->assertSame(0.5, $hsla->alpha());
    }

    /** @test */
    public function it_cant_be_initialized_with_a_negative_saturation()
    {
        $this->expectException(InvalidColorValue::class);

        new Hsla(-5, -1, 67);
    }

    /** @test */
    public function it_cant_be_initialized_with_a_saturation_higher_than_100()
    {
        $this->expectException(InvalidColorValue::class);

        new Hsla(-5, 108, 67);
    }

    /** @test */
    public function it_cant_be_initialized_with_a_negative_lightness()
    {
        $this->expectException(InvalidColorValue::class);

        new Hsla(-5, 55, -67);
    }

    /** @test */
    public function it_cant_be_initialized_with_a_lightness_higher_than_100()
    {
        $this->expectException(InvalidColorValue::class);

        new Hsla(-5, 55, 102);
    }

    /** @test */
    public function it_cant_be_initialized_with_a_negative_alpha_value()
    {
        $this->expectException(InvalidColorValue::class);

        new Hsla(255, 55, 25, -1);
    }

    /** @test */
    public function it_cant_be_initialized_with_an_alpha_value_higher_than_1()
    {
        $this->expectException(InvalidColorValue::class);

        new Hsla(255, 0.25, 55, 1.5);
    }

    /** @test */
    public function it_can_be_created_from_a_string()
    {
        $hsla = Hsla::fromString('hsla(205,35%,17%,0.78)');

        $this->assertInstanceOf(Hsla::class, $hsla);
        $this->assertSame(205.0, $hsla->hue());
        $this->assertSame(35.0, $hsla->saturation());
        $this->assertSame(17.0, $hsla->lightness());
        $this->assertSame(0.78, $hsla->alpha());
    }

    /** @test */
    public function it_can_be_created_from_a_string_without_percentages()
    {
        $hsla = Hsla::fromString('hsla(205,35,17,0.78)');

        $this->assertInstanceOf(Hsla::class, $hsla);
        $this->assertSame(205.0, $hsla->hue());
        $this->assertSame(35.0, $hsla->saturation());
        $this->assertSame(17.0, $hsla->lightness());
        $this->assertSame(0.78, $hsla->alpha());
    }

    /** @test */
    public function it_can_be_created_from_a_string_with_spaces()
    {
        $hsla = Hsla::fromString('  hsla(  205  ,  35%  ,  17%  ,  0.89  )  ');

        $this->assertInstanceOf(Hsla::class, $hsla);
        $this->assertSame(205.0, $hsla->hue());
        $this->assertSame(35.0, $hsla->saturation());
        $this->assertSame(17.0, $hsla->lightness());
        $this->assertSame(0.89, $hsla->alpha());
    }

    /** @test */
    public function it_cant_be_created_from_malformed_string()
    {
        $this->expectException(InvalidColorValue::class);

        Hsla::fromString('hsla(205,0.35,0.17,0.78');
    }

    /** @test */
    public function it_cant_be_created_from_a_string_with_text_around()
    {
        $this->expectException(InvalidColorValue::class);

        Hsla::fromString('abc hsla(205,0.35,0.17,0.78) abc');
    }

    /** @test */
    public function it_can_be_casted_to_a_string()
    {
        $hsla = new Hsla(55, 15, 25, 0.4);

        $this->assertSame('hsla(55,15%,25%,0.4)', (string) $hsla);
    }

    /** @test
     * @dataProvider provides_hsl_string_and_rgb_values
     */
    public function it_calculates_rgb_values($hslaString, $red, $green, $blue)
    {
        $hsla = Hsla::fromString($hslaString);

        $this->assertSame($red, $hsla->red());
        $this->assertSame($green, $hsla->green());
        $this->assertSame($blue, $hsla->blue());
    }

    /** @test */
    public function it_can_be_converted_to_CIELab()
    {
        $hsla = new Hsla(55, 15, 25, 0.4);
        $lab = $hsla->toCIELab();

        $this->assertSame(30.20, $lab->l());
        $this->assertSame(-3.07, $lab->a());
        $this->assertSame(10.98, $lab->b());
    }

    /** @test */
    public function it_can_be_converted_to_cmyk() {
        $hsla = new Hsla(55, 15, 25, 0.4);
        $cmyk = $hsla->toCmyk();

        $this->assertSame($hsla->red(), $cmyk->red());
        $this->assertSame($hsla->green(), $cmyk->green());
        $this->assertSame($hsla->blue(), $cmyk->blue());
    }

    /** @test */
    public function it_can_be_converted_to_hsla()
    {
        $hsla = new Hsla(55, 55, 67);
        $newHsla = $hsla->toHsla(0.5);

        $this->assertSame($hsla->hue(), $newHsla->hue());
        $this->assertSame($hsla->saturation(), $newHsla->saturation());
        $this->assertSame($hsla->lightness(), $newHsla->lightness());
        $this->assertSame(0.5, $newHsla->alpha());
        $this->assertNotSame($hsla, $newHsla);
    }

    /** @test */
    public function it_can_be_converted_to_hsl()
    {
        $hsla = new Hsla(55, 55, 67);
        $hsl = $hsla->toHsl();

        $this->assertSame($hsla->hue(), $hsl->hue());
        $this->assertSame($hsla->saturation(), $hsl->saturation());
        $this->assertSame($hsla->lightness(), $hsl->lightness());
    }

    /** @test */
    public function it_can_be_converted_to_rgb()
    {
        $hsla = new Hsla(55, 55, 67);
        $rgb = $hsla->toRgb();

        $this->assertSame(217, $rgb->red());
        $this->assertSame(209, $rgb->green());
        $this->assertSame(125, $rgb->blue());
    }

    /** @test */
    public function it_can_be_converted_to_rgba_with_a_specific_alpha_value()
    {
        $hsla = new Hsla(55, 55, 67);
        $rgba = $hsla->toRgba(0.5);

        $this->assertSame(217, $rgba->red());
        $this->assertSame(209, $rgba->green());
        $this->assertSame(125, $rgba->blue());
        $this->assertSame(0.5, $rgba->alpha());
    }

    /** @test */
    public function it_can_be_converted_to_hex()
    {
        $hsla = new Hsla(55, 55, 67);
        $hex = $hsla->toHex();

        $this->assertSame('d9', $hex->red());
        $this->assertSame('d1', $hex->green());
        $this->assertSame('7d', $hex->blue());
    }

    public function it_can_be_converted_to_xyz()
    {
        $hsla = new Hsla(55, 55, 67);
        $xyz = $hsla->toXyz();

        $this->assertSame(55.1174, $xyz->x());
        $this->assertSame(61.8333, $xyz->y());
        $this->assertSame(28.4321, $xyz->z());
    }

    public function provides_hsl_string_and_rgb_values()
    {
        return [
            'hsla(55, 15%, 25%, 0.1)' => ['hsla(55, 15%, 25%, 0.1)', 73, 72, 54],
            'hsla(95, 65%, 25%, 0.1)' => ['hsla(95, 65%, 25%, 0.1)', 57, 105, 22],
            'hsla(127, 35%, 75%, 0.1)' => ['hsla(127, 35%, 75%, 0.1)', 169, 214, 174],
            'hsla(200, 65%, 75%, 0.1)' => ['hsla(200, 65%, 75%, 0.1)', 150, 205, 233],
            'hsla(242, 35%, 25%, 0.1)' => ['hsla(242, 35%, 25%, 0.1)', 43, 41, 86],
            'hsla(319, 65%, 25%, 0.1)' => ['hsla(319, 65%, 25%, 0.1)', 105, 22, 79],
        ];
    }
}
