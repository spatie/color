<?php

namespace Spatie\Color\Test;

use PHPUnit\Framework\TestCase;
use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Factory;
use Spatie\Color\Hex;
use Spatie\Color\Hsl;
use Spatie\Color\Hsla;
use Spatie\Color\Rgb;
use Spatie\Color\Rgba;

class FactoryTest extends TestCase
{
    /** @test */
    public function it_can_create_a_hex_color_from_a_string()
    {
        $hex = Factory::fromString('#aabbcc');

        $this->assertInstanceOf(Hex::class, $hex);
    }

    /** @test */
    public function it_can_create_a_hex_color_calculating_a_string_hash()
    {
        $hex = Factory::stringToColor("Hello world!");

        $this->assertInstanceOf(Hex::class, $hex);
    }

    /** @test */
    public function it_can_create_a_hsl_color_from_a_string()
    {
        $hsl = Factory::fromString('hsl(127, 45%, 71%)');

        $this->assertInstanceOf(Hsl::class, $hsl);
    }

    /** @test */
    public function it_can_create_a_hsla_color_from_a_string()
    {
        $hsla = Factory::fromString('hsla(127, 45%, 71%, 0.33)');

        $this->assertInstanceOf(Hsla::class, $hsla);
    }

    /** @test */
    public function it_can_create_a_rgb_color_from_a_string()
    {
        $rgb = Factory::fromString('rgb(55,155,255)');

        $this->assertInstanceOf(Rgb::class, $rgb);
    }

    /** @test */
    public function it_can_create_a_rgba_color_from_a_string()
    {
        $rgba = Factory::fromString('rgba(55,155,255,0.5)');

        $this->assertInstanceOf(Rgba::class, $rgba);
    }

    /** @test */
    public function it_cant_create_a_color_from_malformed_string()
    {
        $this->expectException(InvalidColorValue::class);

        Factory::fromString('abcd');
    }
}
