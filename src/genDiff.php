<?php

namespace php\project\lvl2\src\Differ;

function typeValueToString($value)
{
     return trim(var_export($value, true), "'");
}

function genDiff($parsedArrayOfFileOne, $parsedArrayOfFileTwo)
{
    $resultArr = [];

    $arrayMergedKeysArr = array_merge($parsedArrayOfFileOne, $parsedArrayOfFileTwo);
    ksort($arrayMergedKeysArr);
    foreach ($arrayMergedKeysArr as $itemKey => $itemOne) {

        // $firstStringViewOfValue = null;
        // $secondStringViewOfValue = null;
        // if (){

        // }
        // if (){
            
        // }
        // if (!is_array($parsedArrayOfFileOne[$itemKey])) {
        //     $firstStringViewOfValue = typeValueToString($parsedArrayOfFileOne[$itemKey]);
        // } else {
        //     $firstStringViewOfValue = "array";
        // }
        // if (!is_array($parsedArrayOfFileTwo[$itemKey])) {
        //     $secondStringViewOfValue = typeValueToString($parsedArrayOfFileTwo[$itemKey]);
        // } else {
        //     $secondStringViewOfValue = "array";
        // }

        if (isset($firstStringViewOfValue) && !isset($secondStringViewOfValue)) {
            $resultArr[] = [
                "key" => $itemKey, 
                "firstArrValue" => $parsedArrayOfFileOne[$itemKey], 
                "secondArrValue" => null,
                "children" => null,
                "cmpResult" => 1
            ];
        }
        if (!isset($firstStringViewOfValue) && isset($secondStringViewOfValue)) {
            $resultArr[] = [
                "key" => $itemKey, 
                "firstArrValue" => null, 
                "secondArrValue" => $parsedArrayOfFileTwo[$itemKey],
                "children" => null,
                "cmpResult" => 2
            ];
        }
        if (isset($firstStringViewOfValue) && isset($secondStringViewOfValue)) {
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

    $resultString .= "{\n";
    foreach ($arrayToType as $itemKey => $itemValue) {
        if (is_array($itemValue)){
            $childString = typeNestedArrayAsString($itemValue, $nextNestedLvl);
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
    $spaces = str_repeat ("    ", $nestedLevel);

    $resultString .= "{\n";
    foreach ($arrayToOutAsString as $key => $arr){
        $keyOfStructure = $arr['key'];
        $firstValueOfStructure = $arr['firstArrValue'];
        $secondValueOfStructure = $arr['secondArrValue'];
        switch ($arr['cmpResult']){
            case 1:
                if($arr['children'] === null && !is_array($firstValueOfStructure)){
                    $stringifyValue = typeValueToString($firstValueOfStructure);
                    $resultString .= "{$spaces}  - {$keyOfStructure}: {$stringifyValue}\n";
                } elseif ($arr['children'] === null && is_array($firstValueOfStructure)){
                    $childString = typeNestedArrayAsString($firstValueOfStructure, $nextNestedLvl);
                    $resultString .= "{$spaces}  - {$keyOfStructure}: {$childString}\n";
                } elseif ($arr['children'] !== null){
                    $childString = stylish($arr['children'], $nextNestedLvl);
                    $resultString .= "{$spaces}    {$keyOfStructure}: {$childString}\n";
                }
                break;
            case 2:
                if($arr['children'] === null && !is_array($secondValueOfStructure)){
                    $stringifyValue = typeValueToString($secondValueOfStructure);
                    $resultString .= "{$spaces}  + {$keyOfStructure}: {$stringifyValue}\n";
                } elseif ($arr['children'] === null && is_array($secondValueOfStructure)){
                    $childString = typeNestedArrayAsString($secondValueOfStructure, $nextNestedLvl);
                    $resultString .= "{$spaces}  + {$keyOfStructure}: {$childString}\n";
                } elseif ($arr['children'] !== null){
                    $childString = stylish($arr['children'], $nextNestedLvl);
                    $resultString .= "{$spaces}    {$keyOfStructure}: {$childString}\n";
                }
                break;
            case 3:
                if($arr['children'] === null){
                    $stringifyValue = typeValueToString($firstValueOfStructure);
                    $resultString .= "{$spaces}    {$keyOfStructure}: {$stringifyValue}\n";
                } else {
                    $childString = stylish($arr['children'], $nextNestedLvl);
                    $resultString .= "{$spaces}    {$keyOfStructure}: {$childString}\n";
                }
                break;
            case 4:
                    if($arr['children'] === null){
                        if (!is_array($firstValueOfStructure)){
                            $stringifyValue = typeValueToString($firstValueOfStructure);
                            $resultString .= "{$spaces}  - {$keyOfStructure}: {$stringifyValue}\n";
                        } else {
                            $childString = typeNestedArrayAsString($firstValueOfStructure, $nextNestedLvl);
                            $resultString .= "{$spaces}  - {$keyOfStructure}: {$childString}\n";
                        }
                        if (!is_array($secondValueOfStructure)){
                            $stringifyValue = typeValueToString($secondValueOfStructure);
                            $resultString .= "{$spaces}  + {$keyOfStructure}: {$stringifyValue}\n";
                        } else {
                            $childString = typeNestedArrayAsString($secondValueOfStructure, $nextNestedLvl);
                            $resultString .= "{$spaces}  + {$keyOfStructure}: {$childString}\n";
                        }
                    }
                break;
        }
    }
    $resultString .= "{$spaces}}";

    return $resultString;
}