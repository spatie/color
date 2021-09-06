<?php

namespace Spatie\Color\Test;

use PHPUnit\Framework\TestCase;
use Spatie\Color\Color;
use Spatie\Color\Contrast;
use Spatie\Color\Hex;

class ContrastTest extends TestCase
{
    /**
     * @test
     * @dataProvider provider
     */
    public function it_can_calculate_contrast(Color $a, Color $b, float $contrast)
    {
        $this->assertSame($contrast, Contrast::ratio($a, $b));
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function it_can_calculate_contrast_from_another_format(Color $a, Color $b, float $contrast)
    {
        $this->assertSame($contrast, Contrast::ratio($a->toRgba(), $b->toHsl()));
    }

    public function provider(): array
    {
        return [
            [Hex::fromString('#ffffff'), Hex::fromString('#ffffff'), 1.0],
            [Hex::fromString('#ffffff'), Hex::fromString('#000000'), 21.0],
            [Hex::fromString('#000000'), Hex::fromString('#000000'), 1.0],
            [Hex::fromString('#faebd7'), Hex::fromString('#8a2be2'), 5.0],
            [Hex::fromString('#ff1493'), Hex::fromString('#cd5c5c'), 1.0],
            [Hex::fromString('#f0fff0'), Hex::fromString('#191970'), 15.0],
        ];
    }
}
