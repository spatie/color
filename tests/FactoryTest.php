<?php

namespace Spatie\Color\Test;

use PHPUnit\Framework\TestCase;
use Spatie\Color\CIELab;
use Spatie\Color\Exceptions\InvalidColorValue;
use Spatie\Color\Factory;
use Spatie\Color\Hex;
use Spatie\Color\Hsl;
use Spatie\Color\Hsla;
use Spatie\Color\Rgb;
use Spatie\Color\Rgba;
use Spatie\Color\Xyz;

class FactoryTest extends TestCase
{
    /** @test */
    public function it_can_create_a_CIELab_color_from_a_string()
    {
        $lab = Factory::fromString('CIELab(62.91,5.34,-57.73)');

        $this->assertInstanceOf(CIELab::class, $lab);
    }

    /** @test */
    public function it_can_create_a_hex_color_from_a_string()
    {
        $hex = Factory::fromString('#aabbcc');

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
    public function it_can_create_a_xyz_color_from_a_string()
    {
        $xyz = Factory::fromString('xyz(31.3469,31.4749,99.0308)');

        $this->assertInstanceOf(Xyz::class, $xyz);
    }

    /** @test */
    public function it_cant_create_a_color_from_malformed_string()
    {
        $this->expectException(InvalidColorValue::class);

        Factory::fromString('abcd');
    }

    public function color_provider() {
        yield [
            '#dc3545', // HEX
            'rgb(220,53,69)', // RGB
            'hsla(354,70%,54%,1)', // HSLA
        ];

        yield [
            '#532952', // HEX
            'rgb(83,41,82)', // RGB
            'hsla(301,34%,24%,1)', // HSLA
        ];

        yield [
            '#512952', // HEX
            'rgb(81,41,82)', // RGB
            'hsla(299,33%,24%,1)', // HSLA
        ];

        yield [
            '#faffff', // HEX
            'rgb(250,255,255)', // RGB
            'hsla(180,100%,99%,1)', // HSLA
        ];

        yield [
            '#feffff', // HEX
            'rgb(254,255,255)', // RGB
            'hsla(180,100%,100%,1)', // HSLA
        ];

        yield [
            '#fefeff', // HEX
            'rgb(254,254,255)', // RGB
            'hsla(240,100%,100%,1)', // HSLA
        ];

        yield [
            '#fefefd', // HEX
            'rgb(254,254,253)', // RGB
            'hsla(60,33%,99%,1)', // HSLA
        ];

        yield [
            '#040504', // HEX
            'rgb(4,5,4)', // RGB
            'hsla(120,11%,2%,1)', // HSLA
        ];

        yield [
            '#000000', // HEX
            'rgb(0,0,0)', // RGB
            'hsla(0,0%,0%,1)', // HSLA
        ];

        yield [
            '#808080', // HEX
            'rgb(128,128,128)', // RGB
            'hsla(0,0%,50%,1)', // HSLA
        ];

        yield [
            '#ffffff', // HEX
            'rgb(255,255,255)', // RGB
            'hsla(0,0%,100%,1)', // HSLA
        ];
    }

    /**
     * @dataProvider color_provider
     * @test
     */
    public function it_should_convert_edge_case( $hex, $rgb, $hsla ) {
        $sut = Factory::fromString($hex);

        $this->assertStringMatchesFormat( $hex, (string) $sut->toHex(), '' );
        $this->assertStringMatchesFormat( $rgb, (string) $sut->toRgb(), '' );
        $this->assertStringMatchesFormat( $hsla, (string) $sut->toHsla(), '' );

        $this->assertStringMatchesFormat( $hex, (string) $sut->toRgb()->toHex(), '' );
        $this->assertStringMatchesFormat( $hsla, (string) $sut->toRgb()->toHsla(), '' );

        $this->assertStringMatchesFormat( $rgb, (string) $sut->toHex()->toRgb(), '' );
        $this->assertStringMatchesFormat( $hsla, (string) $sut->toHex()->toHsla(), '' );
    }
}
