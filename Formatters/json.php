<?php

namespace php\project\lvl2\Formatters\Json;

use function php\project\lvl2\src\Functions\typeValueToString;

function jsonFormat($arrayToOutAsString): string
{
    $jsonEncodeResult = json_encode($arrayToOutAsString, JSON_PRETTY_PRINT);
    if (gettype($jsonEncodeResult) === 'string') {
        return $jsonEncodeResult;
    } else {
        return typeValueToString($jsonEncodeResult);
    }
    return $jsonEncodeResult;
}
