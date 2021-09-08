<?php

namespace Spatie\Color\Test;

use PHPUnit\Framework\TestCase;
use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Xyz;

class XyzTest extends TestCase
{
    /** @test */
    public function it_is_initializable()
    {
        $xyz = new Xyz(31.3469, 31.4749, 99.0308);

        $this->assertInstanceOf(Xyz::class, $xyz);
        $this->assertSame(31.3469, $xyz->x());
        $this->assertSame(31.4749, $xyz->y());
        $this->assertSame(99.0308, $xyz->z());
    }

    /** @test */
    public function it_cant_be_initialized_with_a_negative_x_value()
    {
        $this->expectException(InvalidColorValue::class);

        new Xyz(-5.00, 31.4749, 99.0308);
    }

    /** @test */
    public function it_cant_be_initialized_with_an_x_value_higher_than_95_047()
    {
        $this->expectException(InvalidColorValue::class);

        new Xyz(100.00, 31.4749, 99.0308);
    }

    /** @test */
    public function it_cant_be_initialized_with_a_negative_y_value()
    {
        $this->expectException(InvalidColorValue::class);

        new Xyz(31.3469, -5.00, 99.0308);
    }

    /** @test */
    public function it_cant_be_initialized_with_a_y_value_higher_than_100()
    {
        $this->expectException(InvalidColorValue::class);

        new Xyz(31.3469, 150.00, 99.0308);
    }

    /** @test */
    public function it_cant_be_initialized_with_a_negative_z_value()
    {
        $this->expectException(InvalidColorValue::class);

        new Xyz(31.3469, 31.4749, -5.00);
    }

    /** @test */
    public function it_cant_be_initialized_with_a_z_value_higher_than_108_883()
    {
        $this->expectException(InvalidColorValue::class);

        new Xyz(31.3469, 31.4749, 150.00);
    }

    /** @test */
    public function it_can_be_created_from_a_string()
    {
        $xyz = Xyz::fromString('xyz(31.3469,31.4749,99.0308)');

        $this->assertInstanceOf(Xyz::class, $xyz);
        $this->assertSame(31.3469, $xyz->x());
        $this->assertSame(31.4749, $xyz->y());
        $this->assertSame(99.0308, $xyz->z());
    }

    /** @test */
    public function it_can_be_created_from_a_string_with_spaces()
    {
        $xyz = Xyz::fromString('  xyz(  31.3469  ,  31.4749  ,  99.0308  )  ');

        $this->assertInstanceOf(Xyz::class, $xyz);
        $this->assertSame(31.3469, $xyz->x());
        $this->assertSame(31.4749, $xyz->y());
        $this->assertSame(99.0308, $xyz->z());
    }

    /** @test */
    public function it_cant_be_created_from_malformed_string()
    {
        $this->expectException(InvalidColorValue::class);

        Xyz::fromString('xyz(31.3469,31.4749,99.0308');
    }

    /** @test */
    public function it_cant_be_created_from_a_string_with_text_around()
    {
        $this->expectException(InvalidColorValue::class);

        Xyz::fromString('abc xyz(31.3469,31.4749,99.0308) abc');
    }

    /** @test */
    public function it_can_be_casted_to_a_string()
    {
        $xyz = new Xyz(31.3469, 31.4749, 99.0308);

        $this->assertSame('xyz(31.3469,31.4749,99.0308)', (string) $xyz);
    }

    /** @test */
    public function it_can_be_converted_to_CIELab()
    {
        $xyz = new Xyz(31.3469, 31.4749, 99.0308);
        $lab = $xyz->toCIELab();

        $this->assertSame(62.91, $lab->l());
        $this->assertSame(5.34, $lab->a());
        $this->assertSame(-57.73, $lab->b());
    }

    /** @test */
    public function it_can_be_converted_to_cmyk() {
        $xyz = new Xyz(31.3469, 31.4749, 99.0308);
        $cmyk = $xyz->toCmyk();

        $this->assertSame($xyz->red(), $cmyk->red());
        $this->assertSame($xyz->green(), $cmyk->green());
        $this->assertSame($xyz->blue(), $cmyk->blue());
    }

    /** @test */
    public function it_can_be_converted_to_rgb()
    {
        $xyz = new Xyz(31.3469, 31.4749, 99.0308);
        $rgb = $xyz->toRgb();

        $this->assertSame(55, $rgb->red());
        $this->assertSame(155, $rgb->green());
        $this->assertSame(255, $rgb->blue());
    }

    /** @test */
    public function it_can_be_converted_to_rgba_with_a_specific_alpha_value()
    {
        $xyz = new Xyz(31.3469, 31.4749, 99.0308);
        $rgba = $xyz->toRgba(0.5);

        $this->assertSame(55, $rgba->red());
        $this->assertSame(155, $rgba->green());
        $this->assertSame(255, $rgba->blue());
        $this->assertSame(0.5, $rgba->alpha());
    }

    /** @test */
    public function it_can_be_converted_to_hex()
    {
        $xyz = new Xyz(31.3469, 31.4749, 99.0308);
        $hex = $xyz->toHex();

        $this->assertSame('37', $hex->red());
        $this->assertSame('9b', $hex->green());
        $this->assertSame('ff', $hex->blue());
    }

    /** @test */
    public function it_can_be_converted_to_hsl()
    {
        $xyz = new Xyz(31.3469, 31.4749, 99.0308);
        $hsl = $xyz->toHsl();

        $this->assertSame(55, $hsl->red());
        $this->assertSame(155, $hsl->green());
        $this->assertSame(255, $hsl->blue());
    }

    /** @test */
    public function it_can_be_converted_to_hsla_with_a_specific_alpha_value()
    {
        $xyz = new Xyz(31.3469, 31.4749, 99.0308);
        $hsla = $xyz->toHsla(0.5);

        $this->assertSame(55, $hsla->red());
        $this->assertSame(155, $hsla->green());
        $this->assertSame(255, $hsla->blue());
        $this->assertSame(0.5, $hsla->alpha());
    }

    /** @test */
    public function it_can_be_converted_to_xyz()
    {
        $xyz = new Xyz(31.3469, 31.4749, 99.0308);
        $newXyz = $xyz->toXyz();

        $this->assertSame($xyz->x(), $newXyz->x());
        $this->assertSame($xyz->y(), $newXyz->y());
        $this->assertSame($xyz->z(), $newXyz->z());
        $this->assertNotSame($xyz, $newXyz);
    }
}
