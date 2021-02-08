<?php

namespace php\project\lvl2\Formatters\Stylish;

use function php\project\lvl2\src\Functions\typeValueToString;
use function Funct\Collection\sortBy;

function typeStylishNestedString($arrayToType, $nestedLevel): string
{
    //$resultString = '';
    $nextNestedLvl = $nestedLevel + 1;
    $currSpaces = str_repeat("    ", $nestedLevel);
    $nextSpaces = str_repeat("    ", $nextNestedLvl);

    $startBracket = "{\n";
    $keysArray = array_keys($arrayToType);
    $resultArray = array_map(function ($itemKey) use ($arrayToType, $nextNestedLvl, $nextSpaces): string {
        $itemValue = $arrayToType[$itemKey];

        if (is_array($arrayToType[$itemKey])) {
            $childString = typeStylishNestedString($itemValue, $nextNestedLvl);
            return "{$nextSpaces}{$itemKey}: {$childString}\n";
        } else {
            return "{$nextSpaces}{$itemKey}: {$itemValue}\n";
        }
    }, $keysArray);
    $resultString = implode('', $resultArray);
    $endBracket = "{$currSpaces}}";
    return "{$startBracket}{$resultString}{$endBracket}";
}

function stylish($arrayToOutAsString, $nestedLevel = 0): string
{
    $nextNestedLvl = $nestedLevel + 1;
    $spaces = str_repeat("    ", $nestedLevel);

    $startBracket = "{\n";
    $resultArray = array_map(function ($arr) use ($spaces, $nextNestedLvl): string {
        $keyOfStructure = $arr['key'];
        $firstValueOfStructure = $arr['firstArrValue'];
        $secondValueOfStructure = $arr['secondArrValue'];
        switch ($arr['cmpResult']) {
            case 1:
                if ($arr['children'] === null && !is_array($firstValueOfStructure)) {
                    [$stringifyValue] = typeValueToString($firstValueOfStructure);
                    return "{$spaces}  - {$keyOfStructure}: {$stringifyValue}\n";
                } elseif ($arr['children'] === null && is_array($firstValueOfStructure)) {
                    $childString = typeStylishNestedString($firstValueOfStructure, $nextNestedLvl);
                    return "{$spaces}  - {$keyOfStructure}: {$childString}\n";
                }
                break;
            case 2:
                if ($arr['children'] === null && !is_array($secondValueOfStructure)) {
                    [$stringifyValue] = typeValueToString($secondValueOfStructure);
                    return "{$spaces}  + {$keyOfStructure}: {$stringifyValue}\n";
                } elseif ($arr['children'] === null && is_array($secondValueOfStructure)) {
                    $childString = typeStylishNestedString($secondValueOfStructure, $nextNestedLvl);
                    return "{$spaces}  + {$keyOfStructure}: {$childString}\n";
                }
                break;
            case 3:
                if ($arr['children'] === null) {
                    [$stringifyValue] = typeValueToString($firstValueOfStructure);
                    return "{$spaces}    {$keyOfStructure}: {$stringifyValue}\n";
                } else {
                    $childString = stylish($arr['children'], $nextNestedLvl);
                    return "{$spaces}    {$keyOfStructure}: {$childString}\n";
                }
            case 4:
                if ($arr['children'] === null) {
                    if (!is_array($firstValueOfStructure)) {
                        [$stringifyValue] = typeValueToString($firstValueOfStructure);
                        $partOne = "{$spaces}  - {$keyOfStructure}: {$stringifyValue}\n";
                    } else {
                        $childString = typeStylishNestedString($firstValueOfStructure, $nextNestedLvl);
                        $partOne = "{$spaces}  - {$keyOfStructure}: {$childString}\n";
                    }
                    if (!is_array($secondValueOfStructure)) {
                        [$stringifyValue] = typeValueToString($secondValueOfStructure);
                        $partTwo = "{$spaces}  + {$keyOfStructure}: {$stringifyValue}\n";
                    } else {
                        $childString = typeStylishNestedString($secondValueOfStructure, $nextNestedLvl);
                        $partTwo = "{$spaces}  + {$keyOfStructure}: {$childString}\n";
                    }
                    return "{$partOne}{$partTwo}";
                }
                break;
        }
        return "";
    }, $arrayToOutAsString);
    $resultString = implode('', $resultArray);
    $endBracket = "{$spaces}}";

    return "{$startBracket}{$resultString}{$endBracket}";
}
