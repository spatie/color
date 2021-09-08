<?php

namespace Spatie\Color\Test;

use PHPUnit\Framework\TestCase;
use Spatie\Color\Convert;
use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Hsb;

class HsbTest extends TestCase
{
    /** @test */
    public function it_is_initializable()
    {
        $hsb = new Hsb(55, 55, 67);

        $this->assertInstanceOf(Hsb::class, $hsb);
        $this->assertSame(55.0, $hsb->hue());
        $this->assertSame(55.0, $hsb->saturation());
        $this->assertSame(67.0, $hsb->brightness());
    }

    /** @test */
    public function it_cant_be_initialized_with_a_negative_saturation()
    {
        $this->expectException(InvalidColorValue::class);

        new Hsb(-5, -1, 67);
    }

    /** @test */
    public function it_cant_be_initialized_with_a_saturation_higher_than_100()
    {
        $this->expectException(InvalidColorValue::class);

        new Hsb(-5, 105, 67);
    }

    /** @test */
    public function it_cant_be_initialized_with_a_negative_brightness()
    {
        $this->expectException(InvalidColorValue::class);

        new Hsb(-5, 55, -67);
    }

    /** @test */
    public function it_cant_be_initialized_with_a_brightness_higher_than_100()
    {
        $this->expectException(InvalidColorValue::class);

        new Hsb(-5, 55, 107);
    }

    /** @test */
    public function it_can_be_created_from_a_string()
    {
        $hsb = Hsb::fromString('hsb(205,35%,17%)');

        $this->assertInstanceOf(Hsb::class, $hsb);
        $this->assertSame(205.0, $hsb->hue());
        $this->assertSame(35.0, $hsb->saturation());
        $this->assertSame(17.0, $hsb->brightness());
    }

    /** @test */
    public function it_can_be_created_from_a_string_without_percentages()
    {
        $hsb = Hsb::fromString('hsb(205,35,17)');

        $this->assertInstanceOf(Hsb::class, $hsb);
        $this->assertSame(205.0, $hsb->hue());
        $this->assertSame(35.0, $hsb->saturation());
        $this->assertSame(17.0, $hsb->brightness());
    }

    /** @test */
    public function it_can_be_created_from_a_string_with_spaces()
    {
        $hsb = Hsb::fromString('  hsb(  205  ,  35%  ,  17%  )  ');

        $this->assertInstanceOf(Hsb::class, $hsb);
        $this->assertSame(205.0, $hsb->hue());
        $this->assertSame(35.0, $hsb->saturation());
        $this->assertSame(17.0, $hsb->brightness());
    }

    /** @test */
    public function it_cant_be_created_from_malformed_string()
    {
        $this->expectException(InvalidColorValue::class);

        Hsb::fromString('hsb(55,155,255');
    }

    /** @test */
    public function it_cant_be_created_from_a_string_with_text_around()
    {
        $this->expectException(InvalidColorValue::class);

        Hsb::fromString('abc hsb(55,155,255) abc');
    }

    /** @test */
    public function it_can_be_casted_to_a_string()
    {
        $hsb = new Hsb(55, 15, 25);

        $this->assertSame('hsb(55,15%,25%)', (string) $hsb);
    }

    /** @test */
    public function it_can_be_converted_to_CIELab()
    {
        $hsb = new Hsb(50,50,50);
        $lab = $hsb->toCIELab();

        $this->assertSame(49.11, $lab->l());
        $this->assertSame(-3.48, $lab->a());
        $this->assertSame(30.6, $lab->b());
    }

    /** @test */
    public function it_can_be_converted_to_cmyk() {
        $hsb = new Hsb(55, 55, 67);
        $cmyk = $hsb->toCmyk();

        $this->assertSame($hsb->red(), $cmyk->red());
        $this->assertSame($hsb->green(), $cmyk->green());
        $this->assertSame($hsb->blue(), $cmyk->blue());
    }

    /** @test */
    public function it_can_be_converted_to_rgb()
    {
        $hsb = new Hsb(50,50,50);
        $rgb = $hsb->toRgb();

        $this->assertSame(128, $rgb->red());
        $this->assertSame(117, $rgb->green());
        $this->assertSame(64, $rgb->blue());
    }

    /** @test */
    public function it_can_be_converted_to_rgba_with_a_specific_alpha_value()
    {
        $hsb = new Hsb(50,50,50);
        $rgba = $hsb->toRgba(0.5);

        $this->assertSame(128, $rgba->red());
        $this->assertSame(117, $rgba->green());
        $this->assertSame(64, $rgba->blue());
        $this->assertSame(0.5, $rgba->alpha());
    }

    /** @test */
    public function it_can_be_converted_to_hex()
    {
        $hsb = new Hsb(50,50,50);
        $hex = $hsb->toHex();

        $this->assertSame('80', $hex->red());
        $this->assertSame('75', $hex->green());
        $this->assertSame('40', $hex->blue());
    }

    public function it_can_be_converted_to_xyz()
    {
        $hsb = new Hsb(55, 55, 67);
        $xyz = $hsb->toXyz();

        $this->assertSame(55.1174, $xyz->x());
        $this->assertSame(61.8333, $xyz->y());
        $this->assertSame(28.4321, $xyz->z());
    }
}
