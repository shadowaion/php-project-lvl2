<?php

namespace php\project\lvl2\Formatters\Json;

use function php\project\lvl2\src\Functions\typeValueToString;

function typeJsonNestedString($arrayToType, $nestedLevel)
{
    $resultString = '';
    $nextNestedLvl = $nestedLevel + 1;
    $currSpaces = str_repeat("    ", $nestedLevel);
    $nextSpaces = str_repeat("    ", $nextNestedLvl);

    $resultString .= "{\n";
    foreach ($arrayToType as $itemKey => $itemValue) {
        if (is_array($itemValue)) {
            $childString = typeJsonNestedString($itemValue, $nextNestedLvl);
            $resultString .= "{$nextSpaces}\"{$itemKey}\": {$childString}\n";
        } else {
            if (gettype($itemKey) === 'string') {
                $resultString .= "{$nextSpaces}\"{$itemKey}\": \"{$itemValue}\"\n";
            } else {
                $resultString .= "{$nextSpaces}\"{$itemKey}\": {$itemValue}\n";
            }
        }
    }
    $resultString .= "{$currSpaces}}";

    return $resultString;
}

function json($arrayToOutAsString, $nestedLevel = 0)
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
                    if ($arr['secondValueType'] === 'string') {
                        $resultString .= "{$spaces}  - \"{$keyOfStructure}\": \"{$stringifyValue}\"\n";
                    } else {
                        $resultString .= "{$spaces}  - \"{$keyOfStructure}\": {$stringifyValue}\n";
                    }
                } elseif ($arr['children'] === null && is_array($firstValueOfStructure)) {
                    $childString = typeJsonNestedString($firstValueOfStructure, $nextNestedLvl);
                    $resultString .= "{$spaces}  - \"{$keyOfStructure}\": {$childString}\n";
                }
                break;
            case 2:
                if ($arr['children'] === null && !is_array($secondValueOfStructure)) {
                    $stringifyValue = typeValueToString($secondValueOfStructure);
                    if ($arr['secondValueType'] === 'string') {
                        $resultString .= "{$spaces}  + \"{$keyOfStructure}\": \"{$stringifyValue}\"\n";
                    } else {
                        $resultString .= "{$spaces}  + \"{$keyOfStructure}\": {$stringifyValue}\n";
                    }
                } elseif ($arr['children'] === null && is_array($secondValueOfStructure)) {
                    $childString = typeJsonNestedString($secondValueOfStructure, $nextNestedLvl);
                    $resultString .= "{$spaces}  + \"{$keyOfStructure}\": {$childString}\n";
                }
                break;
            case 3:
                if ($arr['children'] === null) {
                    $stringifyValue = typeValueToString($firstValueOfStructure);
                    if ($arr['secondValueType'] === 'string') {
                        $resultString .= "{$spaces}    \"{$keyOfStructure}\": \"{$stringifyValue}\"\n";
                    } else {
                        $resultString .= "{$spaces}    \"{$keyOfStructure}\": {$stringifyValue}\n";
                    }
                    
                } else {
                    $childString = json($arr['children'], $nextNestedLvl);
                    $resultString .= "{$spaces}    \"{$keyOfStructure}\": {$childString}\n";
                }
                break;
            case 4:
                if ($arr['children'] === null) {
                    if (!is_array($firstValueOfStructure)) {
                        $stringifyValue = typeValueToString($firstValueOfStructure);
                        if ($arr['secondValueType'] === 'string') {
                            $resultString .= "{$spaces}  - \"{$keyOfStructure}\": \"{$stringifyValue}\"\n";
                        } else {
                            $resultString .= "{$spaces}  - \"{$keyOfStructure}\": {$stringifyValue}\n";
                        }
                    } else {
                        $childString = typeJsonNestedString($firstValueOfStructure, $nextNestedLvl);
                        $resultString .= "{$spaces}  - \"{$keyOfStructure}\": {$childString}\n";
                    }
                    if (!is_array($secondValueOfStructure)) {
                        $stringifyValue = typeValueToString($secondValueOfStructure);
                        if ($arr['secondValueType'] === 'string') {
                            $resultString .= "{$spaces}  + \"{$keyOfStructure}\": \"{$stringifyValue}\"\n";
                        } else {
                            $resultString .= "{$spaces}  + \"{$keyOfStructure}\": {$stringifyValue}\n";
                        }
                    } else {
                        $childString = typeJsonNestedString($secondValueOfStructure, $nextNestedLvl);
                        $resultString .= "{$spaces}  + \"{$keyOfStructure}\": {$childString}\n";
                    }
                }
                break;
        }
    }
    $resultString .= "{$spaces}}";

    return $resultString;
}