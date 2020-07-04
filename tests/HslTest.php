<?php

namespace Spatie\Color\Test;

use PHPUnit\Framework\TestCase;
use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Hsl;

class HslTest extends TestCase
{
    /** @test */
    public function it_is_initializable()
    {
        $hsl = new Hsl(55, 55, 67);

        $this->assertInstanceOf(Hsl::class, $hsl);
        $this->assertEquals(55, $hsl->hue());
        $this->assertEquals(55, $hsl->saturation());
        $this->assertEquals(67, $hsl->lightness());
    }

    /** @test */
    public function it_cant_be_initialized_with_a_negative_saturation()
    {
        $this->expectException(InvalidColorValue::class);

        new Hsl(-5, -1, 67);
    }

    /** @test */
    public function it_cant_be_initialized_with_a_saturation_higher_than_100()
    {
        $this->expectException(InvalidColorValue::class);

        new Hsl(-5, 105, 67);
    }

    /** @test */
    public function it_cant_be_initialized_with_a_negative_lightness()
    {
        $this->expectException(InvalidColorValue::class);

        new Hsl(-5, 55, -67);
    }

    /** @test */
    public function it_cant_be_initialized_with_a_lightness_higher_than_100()
    {
        $this->expectException(InvalidColorValue::class);

        new Hsl(-5, 55, 107);
    }

    /** @test */
    public function it_can_be_created_from_a_string()
    {
        $hsl = Hsl::fromString('hsl(205,35%,17%)');

        $this->assertInstanceOf(Hsl::class, $hsl);
        $this->assertEquals(205, $hsl->hue());
        $this->assertEquals(35, $hsl->saturation());
        $this->assertEquals(17, $hsl->lightness());
    }

    /** @test */
    public function it_can_be_created_from_a_string_without_percentages()
    {
        $hsl = Hsl::fromString('hsl(205,35,17)');

        $this->assertInstanceOf(Hsl::class, $hsl);
        $this->assertEquals(205, $hsl->hue());
        $this->assertEquals(35, $hsl->saturation());
        $this->assertEquals(17, $hsl->lightness());
    }

    /** @test */
    public function it_can_be_created_from_a_string_with_spaces()
    {
        $hsl = Hsl::fromString('  hsl(  205  ,  35%  ,  17%  )  ');

        $this->assertInstanceOf(Hsl::class, $hsl);
        $this->assertEquals(205, $hsl->hue());
        $this->assertEquals(35, $hsl->saturation());
        $this->assertEquals(17, $hsl->lightness());
    }

    /** @test */
    public function it_cant_be_created_from_malformed_string()
    {
        $this->expectException(InvalidColorValue::class);

        Hsl::fromString('hsl(55,155,255');
    }

    /** @test */
    public function it_cant_be_created_from_a_string_with_text_around()
    {
        $this->expectException(InvalidColorValue::class);

        Hsl::fromString('abc hsl(55,155,255) abc');
    }

    /** @test */
    public function it_can_be_casted_to_a_string()
    {
        $hsl = new Hsl(55, 15, 25);

        $this->assertEquals('hsl(55,15%,25%)', (string) $hsl);
    }

    /** @test
     * @dataProvider provides_hsl_string_and_rgb_values
     */
    public function it_calculates_rgb_values($hslString, $red, $green, $blue)
    {
        $hsl = Hsl::fromString($hslString);

        $this->assertEquals($red, $hsl->red());
        $this->assertEquals($green, $hsl->green());
        $this->assertEquals($blue, $hsl->blue());
    }

    /** @test */
    public function it_can_be_converted_to_hsl()
    {
        $hsl = new Hsl(55, 55, 67);
        $newHsl = $hsl->toHsl();

        $this->assertEquals($hsl->hue(), $newHsl->hue());
        $this->assertEquals($hsl->saturation(), $newHsl->saturation());
        $this->assertEquals($hsl->lightness(), $newHsl->lightness());
        $this->assertNotSame($hsl, $newHsl);
    }

    /** @test */
    public function it_can_be_converted_to_hsla_with_a_specific_alpha_value()
    {
        $hsl = new Hsl(55, 55, 67);
        $hsla = $hsl->toHsla(0.5);

        $this->assertEquals(55, $hsla->hue());
        $this->assertEquals(55, $hsla->saturation());
        $this->assertEquals(67, $hsla->lightness());
        $this->assertEquals(0.5, $hsla->alpha());
    }

    /** @test */
    public function it_can_be_converted_to_rgb()
    {
        $hsl = new Hsl(55, 55, 67);
        $rgb = $hsl->toRgb();

        $this->assertEquals(217, $rgb->red());
        $this->assertEquals(209, $rgb->green());
        $this->assertEquals(125, $rgb->blue());
    }

    /** @test */
    public function it_can_be_converted_to_rgba_with_a_specific_alpha_value()
    {
        $hsl = new Hsl(55, 55, 67);
        $rgba = $hsl->toRgba(0.5);

        $this->assertEquals(217, $rgba->red());
        $this->assertEquals(209, $rgba->green());
        $this->assertEquals(125, $rgba->blue());
        $this->assertEquals(0.5, $rgba->alpha());
    }

    /** @test */
    public function it_can_be_converted_to_hex()
    {
        $hsl = new Hsl(55, 55, 67);
        $hex = $hsl->toHex();

        $this->assertEquals('d9', $hex->red());
        $this->assertEquals('d1', $hex->green());
        $this->assertEquals('7d', $hex->blue());
    }

    public function provides_hsl_string_and_rgb_values()
    {
        return [
            'hsl(0, 20%, 50%)' => ['hsl(0, 20%, 50%)', 153, 102, 102],
            'hsl(360, 20%, 50%)' => ['hsl(360, 20%, 50%)', 153, 102, 102],
            'hsl(55, 0%, 50%)' => ['hsl(55, 0%, 50%)', 128, 128, 128],
            'hsl(55, 100%, 50%)' => ['hsl(55, 100%, 50%)', 255, 234, 0],
            'hsl(55, 50%, 0%)' => ['hsl(55, 50%, 0%)', 0, 0, 0],
            'hsl(55, 50%, 100%)' => ['hsl(55, 50%, 100%)', 255, 255, 255],
            'hsl(55, 15%, 25%)' => ['hsl(55, 15%, 25%)', 73, 72, 54],
            'hsl(95, 65%, 25%)' => ['hsl(95, 65%, 25%)', 57, 105, 22],
            'hsl(127, 35%, 75%)' => ['hsl(127, 35%, 75%)', 169, 214, 174],
            'hsl(200, 65%, 75%)' => ['hsl(200, 65%, 75%)', 150, 205, 233],
            'hsl(242, 35%, 25%)' => ['hsl(242, 35%, 25%)', 43, 41, 86],
            'hsl(319, 65%, 25%)' => ['hsl(319, 65%, 25%)', 105, 22, 79],
            'hsl(-1, 50%, 50%)' => ['hsl(-1, 50%, 50%)', 191, 64, 64],
        ];
    }
}
