<?php

namespace php\project\lvl2\src\Formatters;

use php\project\lvl2\Formatters\Stylish;
use php\project\lvl2\Formatters\Plain;
use php\project\lvl2\Formatters\Json;

function chooseFormatter($genDiffArray, $formatName): string
{
    switch ($formatName) {
        case "stylish":
            return Stylish\stylish($genDiffArray);
            break;
        case "plain":
            return Plain\plain($genDiffArray);
            break;
        case "json":
            return Json\jsonFormat($genDiffArray);
            break;
    }

    return $outputResult;
}
