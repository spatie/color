<?php

namespace Spatie\Color;

interface Color
{
    public static function fromString(string $string);

    public function red();

    public function green();

    public function blue();

    public function __toString(): string;
}
