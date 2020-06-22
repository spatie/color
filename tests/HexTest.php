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
        $this->assertEquals('aa', $hex->red());
        $this->assertEquals('bb', $hex->green());
        $this->assertEquals('cc', $hex->blue());
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
        $this->assertEquals('aa', $hex->red());
        $this->assertEquals('bb', $hex->green());
        $this->assertEquals('cc', $hex->blue());
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

        $this->assertEquals('#aabbcc', (string) $hex);
    }

    /** @test */
    public function it_can_be_converted_to_hex()
    {
        $hex = new Hex('aa', 'bb', 'cc');
        $newHex = $hex->toHex();

        $this->assertEquals($hex->red(), $newHex->red());
        $this->assertEquals($hex->green(), $newHex->green());
        $this->assertEquals($hex->blue(), $newHex->blue());
        $this->assertNotSame($hex, $newHex);
    }

    /** @test */
    public function it_can_be_converted_to_hsl()
    {
        $hex = new Hex('aa', 'bb', 'cc');
        $hsl = $hex->toHsl();

        $this->assertEquals(170, $hsl->red());
        $this->assertEquals(187, $hsl->green());
        $this->assertEquals(204, $hsl->blue());
    }

    /** @test */
    public function it_can_be_converted_to_hsla_with_a_specific_alpha_value()
    {
        $hex = new Hex('aa', 'bb', 'cc');
        $hsla = $hex->toHsla(0.75);

        $this->assertEquals(170, $hsla->red());
        $this->assertEquals(187, $hsla->green());
        $this->assertEquals(204, $hsla->blue());
        $this->assertEquals(0.75, $hsla->alpha());
    }

    /** @test */
    public function it_can_be_converted_to_rgb()
    {
        $hex = new Hex('aa', 'bb', 'cc');
        $rgb = $hex->toRgb();

        $this->assertEquals(170, $rgb->red());
        $this->assertEquals(187, $rgb->green());
        $this->assertEquals(204, $rgb->blue());
    }

    /** @test */
    public function it_can_be_converted_to_rgba()
    {
        $hex = new Hex('aa', 'bb', 'cc');
        $rgba = $hex->toRgba(0.5);

        $this->assertEquals(170, $rgba->red());
        $this->assertEquals(187, $rgba->green());
        $this->assertEquals(204, $rgba->blue());
        $this->assertEquals(0.5, $rgba->alpha());
    }
}
