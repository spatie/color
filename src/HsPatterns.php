<?php

namespace Spatie\Color;

class HsPatterns
{
    protected const HUE = '\d{1,3}';
    protected const COMPONENT = '\d{1,3}(?:\.\d+)?%?';
    protected const ALPHA = '[0-1](?:\.\d{1,2})?';

    private const VALIDATION_PATTERNS = [
        'hsb' => '/^ *hs[vb]\( *-?' . self::HUE . ' *, *' . self::COMPONENT . ' *, *' . self::COMPONENT . ' *\) *$/i',
        'hsl' => '/^ *hsl\( *-?' . self::HUE . ' *, *' . self::COMPONENT . ' *, *' . self::COMPONENT . ' *\) *$/i',
        'hsla' => '/^ *hsla\( *' . self::HUE . ' *, *' . self::COMPONENT . ' *, *' . self::COMPONENT . ' *, *' . self::ALPHA . ' *\) *$/i',
    ];

    private const EXTRACTION_PATTERNS = [
        'hsb' => '/hs[vb]\( *(-?' . self::HUE . ') *, *(' . self::COMPONENT . ') *, *(' . self::COMPONENT . ') *\)/i',
        'hsl' => '/hsl\( *(-?' . self::HUE . ') *, *(' . self::COMPONENT . ') *, *(' . self::COMPONENT . ') *\)/i',
        'hsla' => '/hsla\( *(' . self::HUE . ') *, *(' . self::COMPONENT . ') *, *(' . self::COMPONENT . ') *, *(' . self::ALPHA . ') *\)/i',
    ];

    public static function getValidationPattern(string $type): string
    {
        if (! isset(self::VALIDATION_PATTERNS[$type])) {
            throw new \InvalidArgumentException('Invalid color type: ' . $type);
        }

        return self::VALIDATION_PATTERNS[$type];
    }

    public static function getExtractionPattern(string $type): string
    {
        if (! isset(self::EXTRACTION_PATTERNS[$type])) {
            throw new \InvalidArgumentException('Invalid color type: ' . $type);
        }

        return self::EXTRACTION_PATTERNS[$type];
    }
}
