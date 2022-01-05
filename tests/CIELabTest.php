<?php

namespace Spatie\Color\Test;

use PHPUnit\Framework\TestCase;
use Spatie\Color\CIELab;
use Spatie\Color\Exceptions\InvalidColorValue;

class CIELabTest extends TestCase
{
    /** @test */
    public function it_is_initializable()
    {
        $lab = new CIELab(62.91, 5.34, -57.73);

        $this->assertInstanceOf(CIELab::class, $lab);
        $this->assertSame(62.91, $lab->l());
        $this->assertSame(5.34, $lab->a());
        $this->assertSame(-57.73, $lab->b());
    }

    /** @test */
    public function it_cant_be_initialized_with_a_negative_l_value()
    {
        $this->expectException(InvalidColorValue::class);

        new CIELab(-5.00, 5.34, -57.73);
    }

    /** @test */
    public function it_cant_be_initialized_with_an_l_value_higher_than_100()
    {
        $this->expectException(InvalidColorValue::class);

        new CIELab(150.00, 5.34, -57.73);
    }

    /** @test */
    public function it_cant_be_initialized_with_an_a_value_lower_than_negative_110()
    {
        $this->expectException(InvalidColorValue::class);

        new CIELab(62.91, -150.00, -57.73);
    }

    /** @test */
    public function it_cant_be_initialized_with_an_a_value_higher_than_110()
    {
        $this->expectException(InvalidColorValue::class);

        new CIELab(62.91, 150.00, -57.73);
    }

    /** @test */
    public function it_cant_be_initialized_with_a_b_value_lower_than_negative_110()
    {
        $this->expectException(InvalidColorValue::class);

        new CIELab(62.91, 5.34, -150.00);
    }

    /** @test */
    public function it_cant_be_initialized_with_a_b_value_higher_than_110()
    {
        $this->expectException(InvalidColorValue::class);

        new CIELab(62.91, 5.34, 150.00);
    }

    /** @test */
    public function it_can_be_created_from_a_string()
    {
        $lab = CIELab::fromString('CIELab(62.91,5.34,-57.73)');

        $this->assertInstanceOf(CIELab::class, $lab);
        $this->assertSame(62.91, $lab->l());
        $this->assertSame(5.34, $lab->a());
        $this->assertSame(-57.73, $lab->b());
    }

    /** @test */
    public function it_can_be_created_from_a_string_with_spaces()
    {
        $lab = CIELab::fromString('  CIELab(  62.91,  5.34,  -57.73  )  ');

        $this->assertInstanceOf(CIELab::class, $lab);
        $this->assertSame(62.91, $lab->l());
        $this->assertSame(5.34, $lab->a());
        $this->assertSame(-57.73, $lab->b());
    }

    /** @test */
    public function it_cant_be_created_from_malformed_string()
    {
        $this->expectException(InvalidColorValue::class);

        CIELab::fromString('CIELab(62.91,5.34,-57.73');
    }

    /** @test */
    public function it_cant_be_created_from_a_string_with_text_around()
    {
        $this->expectException(InvalidColorValue::class);

        CIELab::fromString('abc CIELab(62.91,5.34,-57.73) abc');
    }

    /** @test */
    public function it_can_be_casted_to_a_string()
    {
        $lab = new CIELab(62.91, 5.34, -57.73);

        $this->assertSame('CIELab(62.91,5.34,-57.73)', (string) $lab);
    }

    /** @test */
    public function it_can_be_converted_to_CIELab()
    {
        $lab = new CIELab(62.91, 5.34, -57.73);
        $newLab = $lab->toCIELab();

        $this->assertSame($lab->l(), $newLab->l());
        $this->assertSame($lab->a(), $newLab->a());
        $this->assertSame($lab->b(), $newLab->b());
        $this->assertNotSame($lab, $newLab);
    }

    /** @test */
    public function it_can_be_converted_to_cmyk()
    {
        $lab = new CIELab(62.91, 5.34, -57.73);
        $cmyk = $lab->toCmyk();

        $this->assertSame($lab->red(), $cmyk->red());
        $this->assertSame($lab->green(), $cmyk->green());
        $this->assertSame($lab->blue(), $cmyk->blue());
    }

    /** @test */
    public function it_can_be_converted_to_rgb()
    {
        $lab = new CIELab(62.91, 5.34, -57.73);
        $rgb = $lab->toRgb();

        $this->assertSame(55, $rgb->red());
        $this->assertSame(155, $rgb->green());
        $this->assertSame(255, $rgb->blue());
    }

    /** @test */
    public function it_can_be_converted_to_rgba_with_a_specific_alpha_value()
    {
        $lab = new CIELab(62.91, 5.34, -57.73);
        $rgba = $lab->toRgba(0.5);

        $this->assertSame(55, $rgba->red());
        $this->assertSame(155, $rgba->green());
        $this->assertSame(255, $rgba->blue());
        $this->assertSame(0.5, $rgba->alpha());
    }

    /** @test */
    public function it_can_be_converted_to_hex()
    {
        $lab = new CIELab(62.91, 5.34, -57.73);
        $hex = $lab->toHex();

        $this->assertSame('37', $hex->red());
        $this->assertSame('9b', $hex->green());
        $this->assertSame('ff', $hex->blue());
    }

    /** @test */
    public function it_can_be_converted_to_hsl()
    {
        $lab = new CIELab(62.91, 5.34, -57.73);
        $hsl = $lab->toHsl();

        $this->assertSame(55, $hsl->red());
        $this->assertSame(155, $hsl->green());
        $this->assertSame(255, $hsl->blue());
    }

    /** @test */
    public function it_can_be_converted_to_hsla_with_a_specific_alpha_value()
    {
        $lab = new CIELab(62.91, 5.34, -57.73);
        $hsla = $lab->toHsla(0.5);

        $this->assertSame(55, $hsla->red());
        $this->assertSame(155, $hsla->green());
        $this->assertSame(255, $hsla->blue());
        $this->assertSame(0.5, $hsla->alpha());
    }

    /** @test */
    public function it_can_be_converted_to_xyz()
    {
        $lab = new CIELab(62.91, 5.34, -57.73);
        $xyz = $lab->toXyz();

        $this->assertSame(31.3514, $xyz->x());
        $this->assertSame(31.4791, $xyz->y());
        $this->assertSame(99.0395, $xyz->z());
    }
}
