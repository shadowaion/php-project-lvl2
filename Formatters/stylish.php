<?php

namespace php\project\lvl2\Formatters\Stylish;

use function php\project\lvl2\src\Functions\typeValueToString;

function typeStylishNestedString($arrayToType, $nestedLevel)
{
    $resultString = '';
    $nextNestedLvl = $nestedLevel + 1;
    $currSpaces = str_repeat("    ", $nestedLevel);
    $nextSpaces = str_repeat("    ", $nextNestedLvl);

    $resultString .= "{\n";
    foreach ($arrayToType as $itemKey => $itemValue) {
        if (is_array($itemValue)) {
            $childString = typeStylishNestedString($itemValue, $nextNestedLvl);
            $resultString .= "{$nextSpaces}{$itemKey}: {$childString}\n";
        } else {
            $resultString .= "{$nextSpaces}{$itemKey}: {$itemValue}\n";
        }
    }
    $resultString .= "{$currSpaces}}";

    return $resultString;
}

function stylish($arrayToOutAsString, $nestedLevel = 0)
{
    $resultString = '';
    $nextNestedLvl = $nestedLevel + 1;
    $spaces = str_repeat("    ", $nestedLevel);

    $resultString .= "{\n";
    foreach ($arrayToOutAsString as $key => $arr) {
        $keyOfStructure = $arr['key'];
        $firstValueOfStructure = $arr['firstArrValue'];
        $secondValueOfStructure = $arr['secondArrValue'];
        switch ($arr['cmpResult']) {
            case 1:
                if ($arr['children'] === null && !is_array($firstValueOfStructure)) {
                    $stringifyValue = typeValueToString($firstValueOfStructure);
                    $resultString .= "{$spaces}  - {$keyOfStructure}: {$stringifyValue}\n";
                } elseif ($arr['children'] === null && is_array($firstValueOfStructure)) {
                    $childString = typeStylishNestedString($firstValueOfStructure, $nextNestedLvl);
                    $resultString .= "{$spaces}  - {$keyOfStructure}: {$childString}\n";
                }
                break;
            case 2:
                if ($arr['children'] === null && !is_array($secondValueOfStructure)) {
                    $stringifyValue = typeValueToString($secondValueOfStructure);
                    $resultString .= "{$spaces}  + {$keyOfStructure}: {$stringifyValue}\n";
                } elseif ($arr['children'] === null && is_array($secondValueOfStructure)) {
                    $childString = typeStylishNestedString($secondValueOfStructure, $nextNestedLvl);
                    $resultString .= "{$spaces}  + {$keyOfStructure}: {$childString}\n";
                }
                break;
            case 3:
                if ($arr['children'] === null) {
                    $stringifyValue = typeValueToString($firstValueOfStructure);
                    $resultString .= "{$spaces}    {$keyOfStructure}: {$stringifyValue}\n";
                } else {
                    $childString = stylish($arr['children'], $nextNestedLvl);
                    $resultString .= "{$spaces}    {$keyOfStructure}: {$childString}\n";
                }
                break;
            case 4:
                if ($arr['children'] === null) {
                    if (!is_array($firstValueOfStructure)) {
                        $stringifyValue = typeValueToString($firstValueOfStructure);
                        $resultString .= "{$spaces}  - {$keyOfStructure}: {$stringifyValue}\n";
                    } else {
                        $childString = typeStylishNestedString($firstValueOfStructure, $nextNestedLvl);
                        $resultString .= "{$spaces}  - {$keyOfStructure}: {$childString}\n";
                    }
                    if (!is_array($secondValueOfStructure)) {
                        $stringifyValue = typeValueToString($secondValueOfStructure);
                        $resultString .= "{$spaces}  + {$keyOfStructure}: {$stringifyValue}\n";
                    } else {
                        $childString = typeStylishNestedString($secondValueOfStructure, $nextNestedLvl);
                        $resultString .= "{$spaces}  + {$keyOfStructure}: {$childString}\n";
                    }
                }
                break;
        }
    }
    $resultString .= "{$spaces}}";

    return $resultString;
}
