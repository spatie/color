<?php

namespace Spatie\Color\Test;

use PHPUnit\Framework\TestCase;
use Spatie\Color\Cmyk;
use Spatie\Color\Exceptions\InvalidColorValue;

class CmykTest extends TestCase
{
    /** @test */
    public function it_is_initializable()
    {
        $cmyk = new Cmyk(0.5, 0.3, 0.2, 0.1);

        $this->assertInstanceOf(Cmyk::class, $cmyk);
        $this->assertSame(0.5, $cmyk->cyan());
        $this->assertSame(0.3, $cmyk->magenta());
        $this->assertSame(0.2, $cmyk->yellow());
        $this->assertSame(0.1, $cmyk->black());
    }

    /** @test */
    public function it_cant_be_initialized_with_invalid_cmyk_ranges()
    {
        $this->expectException(InvalidColorValue::class);

        new Cmyk(1.0, 1.0, 1.0, 2);
    }

    /** @test */
    public function it_can_be_created_from_a_string()
    {
        $cmyk = Cmyk::fromString('cmyk(100%,50%,10%,25%)');

        $this->assertInstanceOf(Cmyk::class, $cmyk);
        $this->assertSame(1.0, $cmyk->cyan());
        $this->assertSame(0.5, $cmyk->magenta());
        $this->assertSame(0.1, $cmyk->yellow());
        $this->assertSame(0.25, $cmyk->black());
    }

    /** @test */
    public function it_cant_be_created_from_malformed_string()
    {
        $this->expectException(InvalidColorValue::class);

        Cmyk::fromString('cmyk(50%,30%,20%,10%');
    }

    /** @test */
    public function it_cant_be_created_from_a_string_with_text_around()
    {
        $this->expectException(InvalidColorValue::class);

        Cmyk::fromString('abc cmyk(50%,30%,20%,10%) abc');
    }

    /** @test */
    public function it_can_be_casted_to_a_string()
    {
        $cmyk = new Cmyk(0.5, 0.3, 0.2, 0.1);
        $this->assertSame('cmyk(50%,30%,20%,10%)', (string)$cmyk);
    }

    /** @test */
    public function it_can_be_converted_to_CIELab()
    {
        $cmyk = new Cmyk(0.17, 0.08, 0, 0.2);
        $lab = $cmyk->toCIELab();

        $this->assertSame(75.04, $lab->l());
        $this->assertSame(-2.61, $lab->a());
        $this->assertSame(-10.65, $lab->b());
    }

    /** @test */
    public function it_can_be_converted_to_hex()
    {
        $cmyk = new Cmyk(0.17, 0.08, 0, 0.2);
        $hex = $cmyk->toHex();

        $this->assertSame('a9', $hex->red());
        $this->assertSame('bb', $hex->green());
        $this->assertSame('cc', $hex->blue());
    }

    /** @test */
    public function it_can_be_converted_to_hsl()
    {
        $cmyk = new Cmyk(0.17, 0.08, 0, 0.2);
        $hsl = $cmyk->toHsl();

        $this->assertSame($cmyk->red(), $hsl->red());
        $this->assertSame($cmyk->green(), $hsl->green());
        $this->assertSame($cmyk->blue(), $hsl->blue());
    }

    /** @test */
    public function it_can_be_converted_to_hsla_with_a_specific_alpha_value()
    {
        $cmyk = new Cmyk(0.17, 0.08, 0, 0.2);
        $hsla = $cmyk->toHsla(0.75);

        $this->assertSame($cmyk->red(), $hsla->red());
        $this->assertSame($cmyk->green(), $hsla->green());
        $this->assertSame($cmyk->blue(), $hsla->blue());
        $this->assertSame(0.75, $hsla->alpha());
    }

    /** @test */
    public function it_can_be_converted_to_rgb()
    {
        $cmyk = new Cmyk(0.17, 0.08, 0, 0.2);
        $rgb = $cmyk->toRgb();

        $this->assertSame($cmyk->red(), $rgb->red());
        $this->assertSame($cmyk->green(), $rgb->green());
        $this->assertSame($cmyk->blue(), $rgb->blue());
    }

    /** @test */
    public function it_can_be_converted_to_rgba()
    {
        $cmyk = new Cmyk(0.17, 0.08, 0, 0.2);
        $rgba = $cmyk->toRgba(0.5);

        $this->assertSame($cmyk->red(), $rgba->red());
        $this->assertSame($cmyk->green(), $rgba->green());
        $this->assertSame($cmyk->blue(), $rgba->blue());
        $this->assertSame(0.5, $rgba->alpha());
    }

    /** @test */
    public function it_can_be_converted_to_xyz()
    {
        $cmyk = new Cmyk(0.17, 0.08, 0, 0.2);
        $xyz = $cmyk->toXyz();

        $this->assertSame($cmyk->red(), $xyz->red());
        $this->assertSame($cmyk->green(), $xyz->green());
        $this->assertSame($cmyk->blue(), $xyz->blue());
    }
}
