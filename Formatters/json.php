<?php

namespace php\project\lvl2\Formatters\Json;

use function php\project\lvl2\src\Functions\typeValueToString;

function jsonFormat($arrayToOutAsString)
{
    return json_encode($arrayToOutAsString, JSON_PRETTY_PRINT);
}
