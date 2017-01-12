<?php

namespace Spatie\Color\Test;

use Spatie\Color\Rgb;
use Spatie\Color\Exceptions\InvalidColorValue;

class RgbTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_initializable()
    {
        $rgb = new Rgb(55, 155, 255);

        $this->assertInstanceOf(Rgb::class, $rgb);
        $this->assertEquals(55, $rgb->red());
        $this->assertEquals(155, $rgb->green());
        $this->assertEquals(255, $rgb->blue());
    }

    /** @test */
    public function it_cant_be_initialized_with_a_negative_color_value()
    {
        $this->expectException(InvalidColorValue::class);

        new Rgb(-5, 255, 255);
    }

    /** @test */
    public function it_cant_be_initialized_with_a_color_value_higher_than_255()
    {
        $this->expectException(InvalidColorValue::class);

        new Rgb(300, 255, 255);
    }

    /** @test */
    public function it_can_be_created_from_a_string()
    {
        $rgb = Rgb::fromString('rgb(55,155,255)');

        $this->assertInstanceOf(Rgb::class, $rgb);
        $this->assertEquals(55, $rgb->red());
        $this->assertEquals(155, $rgb->green());
        $this->assertEquals(255, $rgb->blue());
    }

    /** @test */
    public function it_cant_be_created_from_malformed_string()
    {
        $this->expectException(InvalidColorValue::class);

        Rgb::fromString('rgb(55,155,255');
    }

    /** @test */
    public function it_can_be_casted_to_a_string()
    {
        $rgb = new Rgb(55, 155, 255);

        $this->assertEquals('rgb(55,155,255)', (string) $rgb);
    }

    /** @test */
    public function it_can_be_converted_to_rgba_with_a_specific_alpha_value()
    {
        $rgb = new Rgb(55, 155, 255);
        $rgba = $rgb->toRgba(0.5);

        $this->assertEquals(55, $rgba->red());
        $this->assertEquals(155, $rgba->green());
        $this->assertEquals(255, $rgba->blue());
        $this->assertEquals(0.5, $rgba->alpha());
    }

    /** @test */
    public function it_can_be_converted_to_hex()
    {
        $rgb = new Rgb(55, 155, 255);
        $hex = $rgb->toHex();

        $this->assertEquals('37', $hex->red());
        $this->assertEquals('9b', $hex->green());
        $this->assertEquals('ff', $hex->blue());
    }
}
