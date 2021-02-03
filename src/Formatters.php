<?php

namespace php\project\lvl2\src\Formatters;

require __DIR__ . './../vendor/autoload.php';

use php\project\lvl2\Formatters\Stylish;
use php\project\lvl2\Formatters\Plain;

function chooseFormatter($genDiffArray, $formatName)
{
    $outputResult = '';

    switch ($formatName) {
        case "stylish":
            $outputResult = Stylish\stylish($genDiffArray);
            break;
        case "plain":
            $outputResult = Plain\plain($genDiffArray);
            break;
    }
    
    return $outputResult;
}
