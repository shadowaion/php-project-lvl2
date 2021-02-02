<?php

namespace php\project\lvl2\src\Differ;

function typeValueToString($value)
{
     return trim(var_export($value, true), "'");
}

function stringify($value, $replacer = ' ', $spacesCount = 1)
{
    $spacesNested = 0;

    $stringifyReduce = function ($value, $replacer, $spacesCount, $spacesNested) use (&$stringifyReduce) {
        $resultString = '';
        if (!is_array($value)) {
            return toString($value);
        } else {
            $resultString .= "{\n";
            $spacesNested += $spacesCount;
            foreach ($value as $valueKey => $valueData) {
                $replacerTimesSpaces = str_repeat($replacer, $spacesNested);
                if (is_array($valueData)) {
                    $currentArrString = $stringifyReduce($valueData, $replacer, $spacesCount, $spacesNested);
                    $resultString .= $replacerTimesSpaces . $valueKey . ": " . $currentArrString . "\n";
                } else {
                    $currentString = $replacerTimesSpaces . toString($valueKey) . ": " . toString($valueData);
                    $resultString .= $currentString . "\n";
                }
            }
            $spacesNested -= $spacesCount;
            $resultString .= str_repeat($replacer, $spacesNested) . "}";
            return $resultString;
        }
    };

    return $stringifyReduce($value, $replacer, $spacesCount, $spacesNested);
}

function genDiff($parsedArrayOfFileOne, $parsedArrayOfFileTwo)
{
    $resultArr = [];

    $arrayMergedKeysArr = array_merge($parsedArrayOfFileOne, $parsedArrayOfFileTwo);
    ksort($arrayMergedKeysArr);
    foreach ($arrayMergedKeysArr as $itemKey => $itemOne) {
        if (isset($parsedArrayOfFileOne[$itemKey]) && !isset($parsedArrayOfFileTwo[$itemKey])) {
            $resultArr[] = [
                "key" => $itemKey, 
                "firstArrValue" => $parsedArrayOfFileOne[$itemKey], 
                "secondArrValue" => null,
                "children" => null,
                "cmpResult" => 1
            ];
        }
        if (!isset($parsedArrayOfFileOne[$itemKey]) && isset($parsedArrayOfFileTwo[$itemKey])) {
            $resultArr[] = [
                "key" => $itemKey, 
                "firstArrValue" => null, 
                "secondArrValue" => $parsedArrayOfFileTwo[$itemKey],
                "children" => null,
                "cmpResult" => 2
            ];
        }
        if (isset($parsedArrayOfFileOne[$itemKey]) && isset($parsedArrayOfFileTwo[$itemKey])) {
            if (is_array($parsedArrayOfFileOne[$itemKey]) && is_array($parsedArrayOfFileTwo[$itemKey])) {
                $childArr = genDiff($parsedArrayOfFileOne[$itemKey], $parsedArrayOfFileTwo[$itemKey]);
                $resultArr[] = [
                    "key" => $itemKey, 
                    "firstArrValue" => $parsedArrayOfFileOne[$itemKey], 
                    "secondArrValue" => $parsedArrayOfFileTwo[$itemKey],
                    "children" => $childArr,
                    "cmpResult" => 3
                ];
            } elseif (!is_array($parsedArrayOfFileOne[$itemKey]) && !is_array($parsedArrayOfFileTwo[$itemKey])) {
                if ($parsedArrayOfFileOne[$itemKey] === $parsedArrayOfFileTwo[$itemKey]) {
                    $resultArr[] = [
                        "key" => $itemKey, 
                        "firstArrValue" => $parsedArrayOfFileOne[$itemKey], 
                        "secondArrValue" => $parsedArrayOfFileTwo[$itemKey],
                        "children" => null,
                        "cmpResult" => 3
                    ];
                } else {
                    $resultArr[] = [
                        "key" => $itemKey, 
                        "firstArrValue" => $parsedArrayOfFileOne[$itemKey], 
                        "secondArrValue" => $parsedArrayOfFileTwo[$itemKey],
                        "children" => null,
                        "cmpResult" => 4
                    ];
                }
            } else {
                $resultArr[] = [
                    "key" => $itemKey, 
                    "firstArrValue" => $parsedArrayOfFileOne[$itemKey], 
                    "secondArrValue" => $parsedArrayOfFileTwo[$itemKey],
                    "children" => null,
                    "cmpResult" => 4
                ];
            }
        }
    }
    return $resultArr;
}

function typeNestedArrayAsString($arrayToType, $nestedLevel)
{
    $resultString = '';
    $nextNestedLvl = $nestedLevel + 1;
    $currSpaces = str_repeat ("    ", $nestedLevel);
    $nextSpaces = str_repeat ("    ", $nextNestedLvl);

    $resultString .= "{$currSpaces}{\n";
    foreach ($arrayMergedKeysArr as $itemKey => $itemValue) {
        if (is_array($itemValue)){
            $childString = typeNestedArrayAsString($itemValue, $nextNestedLvl);
            $resultString .= "{$nextSpaces}{$childString}\n";
        } else {
            $resultString .= "{$nextSpaces}{$itemKey}: {$itemValue}\n";
        }
    }
    $resultString .= "{$currSpaces}}";

    return $resultString;
}

function stylish($arrayToOutAsString, $nestedLevel)
{
    $resultString = '';
    $nextNestedLvl = $nestedLevel + 1;
    $spaces = str_repeat ("    ", $nestedLevel);

    $resultString .= "{$spaces}{\n";
    foreach ($arrToOutAsString as $key => $arr){
        $keyOfStructure = $arr['key'];
        $firstValueOfStructure = $arr['firstArrValue'];
        $secondValueOfStructure = $arr['secondArrValue'];
        switch ($arr['cmpResult']){
            case 1:
                if($arr['children'] === null && !is_array($firstValueOfStructure)){
                    $resultString .= "{$spaces}  - {$keyOfStructure}: {$firstValueOfStructure}\n";
                } elseif ($arr['children'] === null && is_array($firstValueOfStructure)){
                    $childString = typeNestedArrayAsString($firstValueOfStructure, $nextNestedLvl);
                    $resultString .= "{$keyOfStructure}: {$childString}\n";
                } elseif ($arr['children'] !== null){
                    $resultString .= stylish($arr['children'], $nextNestedLvl);
                }
                break;
            case 2:
                if($arr['children'] === null && !is_array($secondValueOfStructure)){
                    $resultString .= "{$spaces}  + {$keyOfStructure}: {$secondValueOfStructure}\n";
                } elseif ($arr['children'] === null && is_array($secondValueOfStructure)){
                    $childString = typeNestedArrayAsString($secondValueOfStructure, $nextNestedLvl);
                    $resultString .= "{$keyOfStructure}: {$childString}\n";
                } elseif ($arr['children'] !== null){
                    $resultString .= stylish($arr['children'], $nextNestedLvl);
                }
                break;
            case 3:
                if($arr['children'] === null){
                    $resultString .= "{$spaces}    {$keyOfStructure}: {$firstValueOfStructure}\n";
                } else {
                    $resultString .= stylish($arr['children'], $nextNestedLvl);
                }
                break;
            case 4:
                    if($arr['children'] === null){
                        if (!is_array($firstValueOfStructure)){
                            $resultString .= "{$spaces}  - {$keyOfStructure}: {$firstValueOfStructure}\n";
                        } else {
                            $childString = typeNestedArrayAsString($firstValueOfStructure, $nextNestedLvl);
                            $resultString .= "{$keyOfStructure}: {$childString}\n";
                        }
                        if (!is_array($secondValueOfStructure)){
                            $resultString .= "{$spaces}  - {$keyOfStructure}: {$secondValueOfStructure}\n";
                        } else {
                            $childString = typeNestedArrayAsString($secondValueOfStructure, $nextNestedLvl);
                            $resultString .= "{$keyOfStructure}: {$childString}\n";
                        }
                    }
                break;
        }
    }
    $resultString .= "{$spaces}}";
}