<?php

use Spatie\Color\Hex;

dataset('contrast_colors', [
    [Hex::fromString('#ffffff'), Hex::fromString('#ffffff'), 1.0],
    [Hex::fromString('#ffffff'), Hex::fromString('#000000'), 21.0],
    [Hex::fromString('#000000'), Hex::fromString('#000000'), 1.0],
    [Hex::fromString('#faebd7'), Hex::fromString('#8a2be2'), 5.0],
    [Hex::fromString('#ff1493'), Hex::fromString('#cd5c5c'), 1.0],
    [Hex::fromString('#f0fff0'), Hex::fromString('#191970'), 15.0],
]);
