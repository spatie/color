<?php

namespace Spatie\Color\Test;

use PHPUnit\Framework\TestCase;
use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Rgba;

class RgbaTest extends TestCase
{
    /** @test */
    public function it_is_initializable()
    {
        $rgba = new Rgba(55, 155, 255, 0.5);

        $this->assertInstanceOf(Rgba::class, $rgba);
        $this->assertSame(55, $rgba->red());
        $this->assertSame(155, $rgba->green());
        $this->assertSame(255, $rgba->blue());
        $this->assertSame(0.5, $rgba->alpha());
    }

    /** @test */
    public function it_cant_be_initialized_with_a_negative_color_value()
    {
        $this->expectException(InvalidColorValue::class);

        new Rgba(-5, 255, 255, 0.5);
    }

    /** @test */
    public function it_cant_be_initialized_with_a_color_value_higher_than_255()
    {
        $this->expectException(InvalidColorValue::class);

        new Rgba(300, 255, 255, 0.5);
    }

    /** @test */
    public function it_cant_be_initialized_with_a_negative_alpha_value()
    {
        $this->expectException(InvalidColorValue::class);

        new Rgba(255, 255, 255, -1);
    }

    /** @test */
    public function it_cant_be_initialized_with_an_alpha_value_higher_than_1()
    {
        $this->expectException(InvalidColorValue::class);

        new Rgba(255, 255, 255, 1.5);
    }

    /** @test */
    public function it_can_be_created_from_a_string()
    {
        $rgba = Rgba::fromString('rgba(55,155,255,0.5)');

        $this->assertInstanceOf(Rgba::class, $rgba);
        $this->assertSame(55, $rgba->red());
        $this->assertSame(155, $rgba->green());
        $this->assertSame(255, $rgba->blue());
        $this->assertSame(0.5, $rgba->alpha());
    }

    /** @test */
    public function it_can_be_created_with_an_opacity_value_without_leading_zero()
    {
        $rgba = Rgba::fromString('rgba(55,155,255,.555)');

        $this->assertInstanceOf(Rgba::class, $rgba);
        $this->assertSame(55, $rgba->red());
        $this->assertSame(155, $rgba->green());
        $this->assertSame(255, $rgba->blue());
        $this->assertSame(.555, $rgba->alpha());
    }

    /** @test */
    public function it_can_be_created_from_a_string_with_3_decimals_in_opacity()
    {
        $rgba = Rgba::fromString('rgba(55,155,255,0.555)');

        $this->assertInstanceOf(Rgba::class, $rgba);
        $this->assertSame(55, $rgba->red());
        $this->assertSame(155, $rgba->green());
        $this->assertSame(255, $rgba->blue());
        $this->assertSame(0.555, $rgba->alpha());
    }

    /** @test */
    public function it_can_be_created_from_a_string_with_spaces()
    {
        $rgba = Rgba::fromString('  rgba(  55  ,  155  ,  255  ,  0.5  )  ');

        $this->assertInstanceOf(Rgba::class, $rgba);
        $this->assertSame(55, $rgba->red());
        $this->assertSame(155, $rgba->green());
        $this->assertSame(255, $rgba->blue());
        $this->assertSame(0.5, $rgba->alpha());
    }

    /** @test */
    public function it_cant_be_created_from_malformed_string()
    {
        $this->expectException(InvalidColorValue::class);

        Rgba::fromString('rgba(55,155,255,0.5');
    }

    /** @test */
    public function it_cant_be_created_from_a_string_with_text_around()
    {
        $this->expectException(InvalidColorValue::class);

        Rgba::fromString('abc rgba(55,155,255,0.5) abc');
    }

    /** @test */
    public function it_can_be_casted_to_a_string()
    {
        $rgba = new Rgba(55, 155, 255, 0.5);

        $this->assertSame('rgba(55,155,255,0.50)', (string) $rgba);
    }

    /** @test */
    public function it_can_be_converted_to_CIELab()
    {
        $rgba = new Rgba(55, 155, 255, 0.5);
        $lab = $rgba->toCIELab();

        $this->assertSame(62.91, $lab->l());
        $this->assertSame(5.34, $lab->a());
        $this->assertSame(-57.73, $lab->b());
    }

    /** @test */
    public function it_can_be_converted_to_cmyk()
    {
        $rgba = new Rgba(55, 155, 255, 0.5);
        $cmyk = $rgba->toCmyk();

        $this->assertSame($rgba->red(), $cmyk->red());
        $this->assertSame($rgba->green(), $cmyk->green());
        $this->assertSame($rgba->blue(), $cmyk->blue());
    }

    /** @test */
    public function it_can_be_converted_to_rgba_with_with_a_specific_alpha_value()
    {
        $rgba = new Rgba(55, 155, 255, 0.5);
        $newRgba = $rgba->toRgba(0.7);

        $this->assertSame(55, $newRgba->red());
        $this->assertSame(155, $newRgba->green());
        $this->assertSame(255, $newRgba->blue());
        $this->assertSame(0.7, $newRgba->alpha());
        $this->assertNotSame($rgba, $newRgba);
    }

    /** @test */
    public function it_can_be_converted_to_rgb_without_an_alpha_value()
    {
        $rgba = new Rgba(55, 155, 255, 0.5);
        $rgb = $rgba->toRgb();

        $this->assertSame(55, $rgb->red());
        $this->assertSame(155, $rgb->green());
        $this->assertSame(255, $rgb->blue());
    }

    /** @test */
    public function it_can_be_converted_to_hex_without_an_alpha_value()
    {
        $rgba = new Rgba(55, 155, 255, 0.5);
        $hex = $rgba->toHex();

        $this->assertSame('37', $hex->red());
        $this->assertSame('9b', $hex->green());
        $this->assertSame('ff', $hex->blue());
    }

    /** @test */
    public function it_can_be_converted_to_hsl_without_an_alpha_value()
    {
        $rgba = new Rgba(55, 155, 255, 0.5);
        $hsl = $rgba->toHsl();

        $this->assertSame(55, $hsl->red());
        $this->assertSame(155, $hsl->green());
        $this->assertSame(255, $hsl->blue());
    }

    /** @test */
    public function it_can_be_converted_to_hsla_with_a_specific_alpha_value()
    {
        $rgba = new Rgba(55, 155, 255, 0.5);
        $hsla = $rgba->toHsla(0.75);

        $this->assertSame(55, $hsla->red());
        $this->assertSame(155, $hsla->green());
        $this->assertSame(255, $hsla->blue());
        $this->assertSame(0.75, $hsla->alpha());
    }

    /** @test */
    public function it_can_be_converted_to_xyz()
    {
        $rgba = new Rgba(55, 155, 255, 0.5);
        $xyz = $rgba->toXyz();

        $this->assertSame(31.3469, $xyz->x());
        $this->assertSame(31.4749, $xyz->y());
        $this->assertSame(99.0308, $xyz->z());
    }
}
