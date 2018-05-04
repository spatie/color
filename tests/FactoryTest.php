<?php

namespace Spatie\Color\Test;

use Spatie\Color\Hex;
use Spatie\Color\Rgb;
use Spatie\Color\Rgba;
use Spatie\Color\Factory;
use PHPUnit\Framework\TestCase;
use Spatie\Color\Exceptions\InvalidColorValue;

class FactoryTest extends TestCase
{
    /** @test */
    public function it_can_create_a_hex_color_from_a_string()
    {
        $hex = Factory::fromString('#aabbcc');

        $this->assertInstanceOf(Hex::class, $hex);
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
