<?php

namespace Spatie\Color\Test;

use PHPUnit\Framework\TestCase;
use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Hex;

class HexTest extends TestCase
{
    /** @test */
    public function it_is_initializable()
    {
        $hex = new Hex('aa', 'bb', 'cc');

        $this->assertInstanceOf(Hex::class, $hex);
        $this->assertSame('aa', $hex->red());
        $this->assertSame('bb', $hex->green());
        $this->assertSame('cc', $hex->blue());
    }

    /** @test */
    public function it_cant_be_initialized_with_invalid_hex_string_lengths()
    {
        $this->expectException(InvalidColorValue::class);

        new Hex('a', 'bb', 'cc');
    }

    /** @test */
    public function it_cant_be_initialized_with_invalid_hex_characters()
    {
        $this->expectException(InvalidColorValue::class);

        new Hex('gg', 'bb', 'cc');
    }

    /** @test */
    public function it_can_be_created_from_a_string()
    {
        $hex = Hex::fromString('#aabbcc');

        $this->assertInstanceOf(Hex::class, $hex);
        $this->assertSame('aa', $hex->red());
        $this->assertSame('bb', $hex->green());
        $this->assertSame('cc', $hex->blue());
    }

    /** @test */
    public function it_cant_be_created_from_a_string_without_a_hash_character()
    {
        $this->expectException(InvalidColorValue::class);

        Hex::fromString('aabbcc');
    }

    /** @test */
    public function it_cant_be_created_from_a_string_with_a_length_too_short()
    {
        $this->expectException(InvalidColorValue::class);

        Hex::fromString('#abbcc');
    }

    /** @test */
    public function it_cant_be_created_from_a_string_with_a_length_too_long()
    {
        $this->expectException(InvalidColorValue::class);

        Hex::fromString('#aabbccddee');
    }

    /** @test */
    public function it_cant_be_created_from_a_string_with_invalid_characters()
    {
        $this->expectException(InvalidColorValue::class);

        Hex::fromString('#ggbbcc');
    }

    /** @test */
    public function it_can_be_casted_to_a_string()
    {
        $hex = new Hex('aa', 'bb', 'cc');

        $this->assertSame('#aabbcc', (string) $hex);
    }

    /** @test */
    public function it_can_be_converted_to_CIELab()
    {
        $hex = new Hex('aa', 'bb', 'cc');
        $lab = $hex->toCIELab();

        $this->assertSame(75.11, $lab->l());
        $this->assertSame(-2.29, $lab->a());
        $this->assertSame(-10.54, $lab->b());
    }

    /** @test */
    public function it_can_be_converted_to_cmyk() {
        $hex = new Hex('aa', 'bb', 'cc');
        $cmyk = $hex->toCmyk();

        $this->assertSame(170, $cmyk->red());
        $this->assertSame(187, $cmyk->green());
        $this->assertSame(204, $cmyk->blue());
    }

    /** @test */
    public function it_can_be_converted_to_hex()
    {
        $hex = new Hex('aa', 'bb', 'cc');
        $newHex = $hex->toHex();

        $this->assertSame($hex->red(), $newHex->red());
        $this->assertSame($hex->green(), $newHex->green());
        $this->assertSame($hex->blue(), $newHex->blue());
        $this->assertNotSame($hex, $newHex);
    }

    /** @test */
    public function it_can_be_converted_to_hsl()
    {
        $hex = new Hex('aa', 'bb', 'cc');
        $hsl = $hex->toHsl();

        $this->assertSame(170, $hsl->red());
        $this->assertSame(187, $hsl->green());
        $this->assertSame(204, $hsl->blue());
    }

    /** @test */
    public function it_can_be_converted_to_hsl_with_same_intensity()
    {
        $hex = new Hex('a8', 'a8', 'a8');
        $hsl = $hex->toHsl();

        $this->assertSame(168, $hsl->red());
        $this->assertSame(168, $hsl->green());
        $this->assertSame(168, $hsl->blue());
    }

    /** @test */
    public function it_can_be_converted_to_hsl_with_a_with_value()
    {
        $hex = new Hex('ff', 'ff', 'ff');
        $hsl = $hex->toHsl();

        $this->assertSame(255, $hsl->red());
        $this->assertSame(255, $hsl->green());
        $this->assertSame(255, $hsl->blue());
    }

    /** @test */
    public function it_can_be_converted_to_hsl_with_a_black_value()
    {
        $hex = new Hex('00', '00', '00');
        $hsl = $hex->toHsl();

        $this->assertSame(0, $hsl->red());
        $this->assertSame(0, $hsl->green());
        $this->assertSame(0, $hsl->blue());
    }

    /** @test */
    public function it_can_be_converted_to_hsla_with_a_specific_alpha_value()
    {
        $hex = new Hex('aa', 'bb', 'cc');
        $hsla = $hex->toHsla(0.75);

        $this->assertSame(170, $hsla->red());
        $this->assertSame(187, $hsla->green());
        $this->assertSame(204, $hsla->blue());
        $this->assertSame(0.75, $hsla->alpha());
    }

    /** @test */
    public function it_can_be_converted_to_rgb()
    {
        $hex = new Hex('aa', 'bb', 'cc');
        $rgb = $hex->toRgb();

        $this->assertSame(170, $rgb->red());
        $this->assertSame(187, $rgb->green());
        $this->assertSame(204, $rgb->blue());
    }

    /** @test */
    public function it_can_be_converted_to_rgba()
    {
        $hex = new Hex('aa', 'bb', 'cc');
        $rgba = $hex->toRgba(0.5);

        $this->assertSame(170, $rgba->red());
        $this->assertSame(187, $rgba->green());
        $this->assertSame(204, $rgba->blue());
        $this->assertSame(0.5, $rgba->alpha());
    }

    public function it_can_be_converted_to_xyz()
    {
        $hex = new Hex('aa', 'bb', 'cc');
        $xyz = $hex->toXyz();

        $this->assertSame(45.2470, $xyz->x());
        $this->assertSame(48.4463, $xyz->y());
        $this->assertSame(64.0930, $xyz->z());
    }
}
