<?php

namespace Spatie\Color\Test;

use PHPUnit\Framework\TestCase;
use Spatie\Color\Distance;
use Spatie\Color\Hex;
use Spatie\Color\Rgb;

class DistanceTest extends TestCase
{
    /** @test */
    public function it_can_compare_distance_using_CIE76()
    {
        $color1 = Rgb::fromString('rgb(55,155,255)');
        $color2 = Hex::fromString('#2d78c8');
        $distance = Distance::CIE76($color1, $color2);

        $this->assertSame(16.35058714542080, $distance);
    }

    /** @test */
    public function it_can_compare_distance_using_CIE76_and_string_colors()
    {
        $distance = Distance::CIE76('rgb(55,155,255)', '#2d78c8');

        $this->assertSame(16.35058714542080, $distance);
    }

    /** @test */
    public function it_can_compare_distance_using_CIE94()
    {
        $color1 = Rgb::fromString('rgb(55,155,255)');
        $color2 = Hex::fromString('#2d78c8');
        $distance = Distance::CIE94($color1, $color2);

        $this->assertSame(13.49091942790753, $distance);
    }

    /** @test */
    public function it_can_compare_distance_using_CIE94_and_string_colors()
    {
        $distance = Distance::CIE94('rgb(55,155,255)', '#2d78c8');

        $this->assertSame(13.49091942790753, $distance);
    }

    /** @test */
    public function it_can_compare_distance_using_CIEDE2000()
    {
        $color1 = Rgb::fromString('rgb(55,155,255)');
        $color2 = Hex::fromString('#2d78c8');
        $distance = Distance::CIEDE2000($color1, $color2);

        $this->assertSame(12.711957696300898, $distance);
    }

    /** @test */
    public function it_can_compare_distance_using_CIEDE2000_and_string_colors()
    {
        $distance = Distance::CIEDE2000('rgb(55,155,255)', '#2d78c8');

        $this->assertSame(12.711957696300898, $distance);
    }
}
