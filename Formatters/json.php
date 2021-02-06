<?php

namespace php\project\lvl2\Formatters\Json;

use function php\project\lvl2\src\Functions\typeValueToString;

function typeJsonNestedString($arrayToType, $nestedLevel)
{
    $resultString = '';
    $nextNestedLvl = $nestedLevel + 1;
    $nextNestedLvlAsArg = $nestedLevel + 2;
    $currSpaces = str_repeat("    ", $nestedLevel);
    $nextSpaces = str_repeat("    ", $nextNestedLvl);

    $resultString .= "{\n";
    foreach ($arrayToType as $itemKey => $itemValue) {
        $resultString .= "{$nextSpaces}{\n";
        $resultString .= "{$nextSpaces}    \"Key\": \"{$itemKey}\"\n";
        $resultString .= "{$nextSpaces}    \"Operation\": \"Unchanged\"\n";
        if (is_array($itemValue)) {
            $childString = typeJsonNestedString($itemValue, $nextNestedLvlAsArg);
            $resultString .= "{$nextSpaces}\"Value\": {$childString}\n";
        } else {
            if (gettype($itemKey) === 'string') {
                $resultString .= "{$nextSpaces}\"Value\": \"{$itemValue}\"\n";
            } else {
                $resultString .= "{$nextSpaces}\"Value\": {$itemValue}\n";
            }
        }
        $resultString .= "{$nextSpaces}}\n";
    }
    $resultString .= "{$currSpaces}}";

    return $resultString;
}

function jsonFormat1($arrayToOutAsString, $nestedLevel = 0)
{
    $resultString = '';
    $nextNestedLvl = $nestedLevel + 1;
    $nextNestedLvlAsArg = $nestedLevel + 2;
    $spaces = str_repeat("    ", $nestedLevel);
    $nextSpaces = str_repeat("    ", $nextNestedLvl);

    //$jsonFormat = json_encode($arrayToOutAsString);
    //print_r($jsonFormat);

    $resultString .= "{\n";
    foreach ($arrayToOutAsString as $key => $arr) {
        $keyOfStructure = $arr['key'];
        $firstValueOfStructure = $arr['firstArrValue'];
        $secondValueOfStructure = $arr['secondArrValue'];
        // switch ($arr['cmpResult']) {
        //     case 1:
        //         if ($arr['children'] === null && !is_array($firstValueOfStructure)) {
        //             $stringifyValue = typeValueToString($firstValueOfStructure);
        //             if ($arr['secondValueType'] === 'string') {
        //                 $resultString .= "{$spaces}  - \"{$keyOfStructure}\": \"{$stringifyValue}\"\n";
        //             } else {
        //                 $resultString .= "{$spaces}  - \"{$keyOfStructure}\": {$stringifyValue}\n";
        //             }
        //         } elseif ($arr['children'] === null && is_array($firstValueOfStructure)) {
        //             $childString = typeJsonNestedString($firstValueOfStructure, $nextNestedLvl);
        //             $resultString .= "{$spaces}  - \"{$keyOfStructure}\": {$childString}\n";
        //         }
        //         break;
        //     case 2:
        //         if ($arr['children'] === null && !is_array($secondValueOfStructure)) {
        //             $stringifyValue = typeValueToString($secondValueOfStructure);
        //             if ($arr['secondValueType'] === 'string') {
        //                 $resultString .= "{$spaces}  + \"{$keyOfStructure}\": \"{$stringifyValue}\"\n";
        //             } else {
        //                 $resultString .= "{$spaces}  + \"{$keyOfStructure}\": {$stringifyValue}\n";
        //             }
        //         } elseif ($arr['children'] === null && is_array($secondValueOfStructure)) {
        //             $childString = typeJsonNestedString($secondValueOfStructure, $nextNestedLvl);
        //             $resultString .= "{$spaces}  + \"{$keyOfStructure}\": {$childString}\n";
        //         }
        //         break;
        //     case 3:
        //         if ($arr['children'] === null) {
        //             $stringifyValue = typeValueToString($firstValueOfStructure);
        //             if ($arr['secondValueType'] === 'string') {
        //                 $resultString .= "{$spaces}    \"{$keyOfStructure}\": \"{$stringifyValue}\"\n";
        //             } else {
        //                 $resultString .= "{$spaces}    \"{$keyOfStructure}\": {$stringifyValue}\n";
        //             }

        //         } else {
        //             $childString = jsonFormat($arr['children'], $nextNestedLvl);
        //             $resultString .= "{$spaces}    \"{$keyOfStructure}\": {$childString}\n";
        //         }
        //         break;
        //     case 4:
        //         if ($arr['children'] === null) {
        //             if (!is_array($firstValueOfStructure)) {
        //                 $stringifyValue = typeValueToString($firstValueOfStructure);
        //                 if ($arr['secondValueType'] === 'string') {
        //                     $resultString .= "{$spaces}  - \"{$keyOfStructure}\": \"{$stringifyValue}\"\n";
        //                 } else {
        //                     $resultString .= "{$spaces}  - \"{$keyOfStructure}\": {$stringifyValue}\n";
        //                 }
        //             } else {
        //                 $childString = typeJsonNestedString($firstValueOfStructure, $nextNestedLvl);
        //                 $resultString .= "{$spaces}  - \"{$keyOfStructure}\": {$childString}\n";
        //             }
        //             if (!is_array($secondValueOfStructure)) {
        //                 $stringifyValue = typeValueToString($secondValueOfStructure);
        //                 if ($arr['secondValueType'] === 'string') {
        //                     $resultString .= "{$spaces}  + \"{$keyOfStructure}\": \"{$stringifyValue}\"\n";
        //                 } else {
        //                     $resultString .= "{$spaces}  + \"{$keyOfStructure}\": {$stringifyValue}\n";
        //                 }
        //             } else {
        //                 $childString = typeJsonNestedString($secondValueOfStructure, $nextNestedLvl);
        //                 $resultString .= "{$spaces}  + \"{$keyOfStructure}\": {$childString}\n";
        //             }
        //         }
        //         break;
        // }
        switch ($arr['cmpResult']) {
            case 1:
                $resultString .= "{$nextSpaces}{\n";
                $resultString .= "{$nextSpaces}    \"Key\": \"{$keyOfStructure}\"\n";
                $resultString .= "{$nextSpaces}    \"Operation\": \"Removed\"\n";
                if ($arr['children'] === null && !is_array($firstValueOfStructure)) {
                    $stringifyValue = typeValueToString($firstValueOfStructure);
                    if ($arr['secondValueType'] === 'string') {
                        $resultString .= "{$nextSpaces}    \"Value\": \"{$stringifyValue}\"\n";
                        //$resultString .= "{$nextSpaces}    \"New value\": \"null\"\n";
                    } else {
                        $resultString .= "{$nextSpaces}    \"Value\": {$stringifyValue}\n";
                        //$resultString .= "{$nextSpaces}    \"New value\": null\n";
                    }
                } elseif ($arr['children'] === null && is_array($firstValueOfStructure)) {
                    $childString = typeJsonNestedString($firstValueOfStructure, $nextNestedLvlAsArg);
                    $resultString .= "{$nextSpaces}    \"Value\": {$childString}\n";
                    //$resultString .= "{$nextSpaces}    \"New value\": null\n";
                }
                $resultString .= "{$nextSpaces}}\n";
                break;
            case 2:
                $resultString .= "{$nextSpaces}{\n";
                $resultString .= "{$nextSpaces}    \"Key\": \"{$keyOfStructure}\"\n";
                $resultString .= "{$nextSpaces}    \"Operation\": \"Added\"\n";
                if ($arr['children'] === null && !is_array($secondValueOfStructure)) {
                    $stringifyValue = typeValueToString($secondValueOfStructure);
                    if ($arr['secondValueType'] === 'string') {
                        $resultString .= "{$nextSpaces}    \"Value\": \"{$stringifyValue}\"\n";
                        //$resultString .= "{$nextSpaces}    \"{$keyOfStructure}\": \"{$stringifyValue}\"\n";
                    } else {
                        $resultString .= "{$nextSpaces}    \"Value\": {$stringifyValue}\n";
                        //$resultString .= "{$nextSpaces}    \"{$keyOfStructure}\": {$stringifyValue}\n";
                    }
                } elseif ($arr['children'] === null && is_array($secondValueOfStructure)) {
                    $childString = typeJsonNestedString($secondValueOfStructure, $nextNestedLvlAsArg);
                    $resultString .= "{$nextSpaces}    \"Value\": {$childString}\n";
                    //$resultString .= "{$nextSpaces}    \"{$keyOfStructure}\": {$childString}\n";
                }
                break;
                $resultString .= "{$nextSpaces}}\n";
            case 3:
                $resultString .= "{$nextSpaces}{\n";
                $resultString .= "{$nextSpaces}    \"Key\": \"{$keyOfStructure}\"\n";
                $resultString .= "{$nextSpaces}    \"Operation\": \"Unchanged\"\n";
                if ($arr['children'] === null) {
                    $stringifyValue = typeValueToString($firstValueOfStructure);
                    if ($arr['secondValueType'] === 'string') {
                        $resultString .= "{$nextSpaces}    \"Value\": \"{$stringifyValue}\"\n";
                    } else {
                        $resultString .= "{$nextSpaces}    \"Value\": {$stringifyValue}\n";
                    }
                } else {
                    $childString = jsonFormat($arr['children'], $nextNestedLvlAsArg);
                    $resultString .= "{$nextSpaces}    \"Value\": {$childString}\n";
                }
                break;
                $resultString .= "{$nextSpaces}}\n";
            case 4:
                $resultString .= "{$nextSpaces}{\n";
                $resultString .= "{$nextSpaces}    \"Key\": \"{$keyOfStructure}\"\n";
                $resultString .= "{$nextSpaces}    \"Operation\": \"Changed\"\n";
                if ($arr['children'] === null) {
                    if (!is_array($firstValueOfStructure)) {
                        $stringifyValue = typeValueToString($firstValueOfStructure);
                        if ($arr['secondValueType'] === 'string') {
                            $resultString .= "{$nextSpaces}    \"Old value\": \"{$stringifyValue}\"\n";
                        } else {
                            $resultString .= "{$nextSpaces}    \"Old value\": {$stringifyValue}\n";
                        }
                    } else {
                        $childString = typeJsonNestedString($firstValueOfStructure, $nextNestedLvlAsArg);
                        $resultString .= "{$nextSpaces}    \"Old value\": {$childString}\n";
                    }
                    if (!is_array($secondValueOfStructure)) {
                        $stringifyValue = typeValueToString($secondValueOfStructure);
                        if ($arr['secondValueType'] === 'string') {
                            $resultString .= "{$nextSpaces}    \"New value\": \"{$stringifyValue}\"\n";
                        } else {
                            $resultString .= "{$nextSpaces}    \"New value\": {$stringifyValue}\n";
                        }
                    } else {
                        $childString = typeJsonNestedString($secondValueOfStructure, $nextNestedLvlAsArg);
                        $resultString .= "{$nextSpaces}    \"New value\": {$childString}\n";
                    }
                }
                break;
                $resultString .= "{$nextSpaces}}\n";
        }
    }
    $resultString .= "{$spaces}}";

    return $resultString;
}

function jsonFormat($arrayToOutAsString, $nestedLevel = 0)
{
    return json_encode($arrayToOutAsString, JSON_PRETTY_PRINT);
}
