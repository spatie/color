<?php

namespace Spatie\Color;

use Spatie\Color\Exceptions\InvalidColorValue;

class Named extends Rgb
{
    protected string $name;

    public function __construct(string $name)
    {
        $this->name = strtolower($name);

        if (! array_key_exists($this->name, Names::ALL)) {
            throw InvalidColorValue::malformedNamedColorString($name);
        }

        $color = Names::ALL[$this->name];

        parent::__construct($color[0], $color[1], $color[2]);
    }

    public static function fromString(string $string): static
    {
        Validate::namedColorString($string);

        return new static($string);
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
