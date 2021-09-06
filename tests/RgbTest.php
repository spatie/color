<?php

namespace Spatie\Color\Test;

use PHPUnit\Framework\TestCase;
use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Rgb;

class RgbTest extends TestCase
{
    /** @test */
    public function it_is_initializable()
    {
        $rgb = new Rgb(55, 155, 255);

        $this->assertInstanceOf(Rgb::class, $rgb);
        $this->assertSame(55, $rgb->red());
        $this->assertSame(155, $rgb->green());
        $this->assertSame(255, $rgb->blue());
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
        $this->assertSame(55, $rgb->red());
        $this->assertSame(155, $rgb->green());
        $this->assertSame(255, $rgb->blue());
    }

    /** @test */
    public function it_can_be_created_from_a_string_with_spaces()
    {
        $rgb = Rgb::fromString('  rgb(  55  ,  155  ,  255  )  ');

        $this->assertInstanceOf(Rgb::class, $rgb);
        $this->assertSame(55, $rgb->red());
        $this->assertSame(155, $rgb->green());
        $this->assertSame(255, $rgb->blue());
    }

    /** @test */
    public function it_cant_be_created_from_malformed_string()
    {
        $this->expectException(InvalidColorValue::class);

        Rgb::fromString('rgb(55,155,255');
    }

    /** @test */
    public function it_cant_be_created_from_a_string_with_text_around()
    {
        $this->expectException(InvalidColorValue::class);

        Rgb::fromString('abc rgb(55,155,255) abc');
    }

    /** @test */
    public function it_can_be_casted_to_a_string()
    {
        $rgb = new Rgb(55, 155, 255);

        $this->assertSame('rgb(55,155,255)', (string) $rgb);
    }

    /** @test */
    public function it_can_be_converted_to_CIELab()
    {
        $rgb = new Rgb(55, 155, 255);
        $lab = $rgb->toCIELab();

        $this->assertSame(62.91, $lab->l());
        $this->assertSame(5.34, $lab->a());
        $this->assertSame(-57.73, $lab->b());
    }

    /** @test */
    public function it_can_be_converted_to_rgb()
    {
        $rgb = new Rgb(55, 155, 255);
        $newRgb = $rgb->toRgb();

        $this->assertSame($rgb->red(), $newRgb->red());
        $this->assertSame($rgb->green(), $newRgb->green());
        $this->assertSame($rgb->blue(), $newRgb->blue());
        $this->assertNotSame($rgb, $newRgb);
    }

    /** @test */
    public function it_can_be_converted_to_rgba_with_a_specific_alpha_value()
    {
        $rgb = new Rgb(55, 155, 255);
        $rgba = $rgb->toRgba(0.5);

        $this->assertSame(55, $rgba->red());
        $this->assertSame(155, $rgba->green());
        $this->assertSame(255, $rgba->blue());
        $this->assertSame(0.5, $rgba->alpha());
    }

    /** @test */
    public function it_can_be_converted_to_hex()
    {
        $rgb = new Rgb(55, 155, 255);
        $hex = $rgb->toHex();

        $this->assertSame('37', $hex->red());
        $this->assertSame('9b', $hex->green());
        $this->assertSame('ff', $hex->blue());
    }

    /** @test */
    public function it_can_be_converted_to_hsl()
    {
        $rgb = new Rgb(55, 155, 255);
        $hsl = $rgb->toHsl();

        $this->assertSame(55, $hsl->red());
        $this->assertSame(155, $hsl->green());
        $this->assertSame(255, $hsl->blue());
    }

    /** @test */
    public function it_can_be_converted_to_hsla_with_a_specific_alpha_value()
    {
        $rgb = new Rgb(55, 155, 255);
        $hsla = $rgb->toHsla(0.5);

        $this->assertSame(55, $hsla->red());
        $this->assertSame(155, $hsla->green());
        $this->assertSame(255, $hsla->blue());
        $this->assertSame(0.5, $hsla->alpha());
    }

    public function it_can_be_converted_to_xyz()
    {
        $rgb = new Rgb(55, 155, 255);
        $xyz = $rgb->toXyz();

        $this->assertSame(31.3469, $xyz->x());
        $this->assertSame(31.4749, $xyz->y());
        $this->assertSame(99.0308, $xyz->z());
    }
}
