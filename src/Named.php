<?php

namespace Spatie\Color;

use Spatie\Color\Exceptions\InvalidColorValue;

class Named extends Rgb
{
    use Names;

    protected $name;

    public function __construct(string $name)
    {

        $this->name = strtolower($name);

        if (! array_key_exists($this->name, $this->names)) {
            throw InvalidColorValue::malformedNamedColorString($name);
        }

        $color = $this->names[$this->name];

        parent::__construct($color[0], $color[1], $color[2]);
    }

    public static function fromString(string $string)
    {
        Validate::namedColorString($string);

        return new static($string);
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
