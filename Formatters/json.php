<?php

namespace php\project\lvl2\Formatters\Json;

use function php\project\lvl2\src\Functions\typeValueToString;

function typeJsonNestedString($arrayToType, $nestedLevel): string
{
    $resultArray = [];
    $nextNestedLvl = $nestedLevel + 1;
    $nextNestedLvlAsArg = $nestedLevel + 2;
    $currSpaces = str_repeat("    ", $nestedLevel);
    $nextSpaces = str_repeat("    ", $nextNestedLvl);

    //$resultArray = "{\n";
    array_push($resultArray, "{\n");
    foreach ($arrayToType as $itemKey => $itemValue) {
        array_push($resultArray, "{$nextSpaces}    \"Key\": \"{$itemKey}\"\n");
        array_push($resultArray, "{$nextSpaces}    \"Operation\": \"Unchanged\"\n");
        //$resultString = "{$resultString}{$nextSpaces}    \"Key\": \"{$itemKey}\"\n";
        //$resultString = "{$resultString}{$nextSpaces}    \"Operation\": \"Unchanged\"\n";
        if (is_array($itemValue)) {
            $childString = typeJsonNestedString($itemValue, $nextNestedLvlAsArg);
            array_push($resultArray, "{$nextSpaces}\"Value\": {$childString}\n");
            //$resultString = "{$resultString}{$nextSpaces}\"Value\": {$childString}\n";
        } else {
            if (gettype($itemKey) === 'string') {
                array_push($resultArray, "{$nextSpaces}\"Value\": \"{$itemValue}\"\n");
                //$resultString = "{$resultString}{$nextSpaces}\"Value\": \"{$itemValue}\"\n";
            } else {
                array_push($resultArray, "{$nextSpaces}\"Value\": {$itemValue}\n");
                //$resultString = "{$resultString}{$nextSpaces}\"Value\": {$itemValue}\n";
            }
        }
        array_push($resultArray, "{$nextSpaces}}\n");
        //$resultString = "{$resultString}{$nextSpaces}}\n";
    }
    array_push($resultArray, "{$currSpaces}}");
    //$resultString = "{$resultString}{$currSpaces}}";
    $resultString = implode('', $resultArray);
    return $resultString;
}

function jsonFormat1($arrayToOutAsString, $nestedLevel = 0)
{
    $resultArray = [];
    //$resultString = '';
    $nextNestedLvl = $nestedLevel + 1;
    $nextNestedLvlAsArg = $nestedLevel + 2;
    $spaces = str_repeat("    ", $nestedLevel);
    $nextSpaces = str_repeat("    ", $nextNestedLvl);

    //$resultString = "{\n";
    array_push($resultArray, "{\n");
    foreach ($arrayToOutAsString as $key => $arr) {
        $keyOfStructure = $arr['key'];
        $firstValueOfStructure = $arr['firstArrValue'];
        $secondValueOfStructure = $arr['secondArrValue'];
        switch ($arr['cmpResult']) {
            case 1:
                //$resultString = "{$resultString}{$nextSpaces}{\n";
                //$resultString = "{$resultString}{$nextSpaces}    \"Key\": \"{$keyOfStructure}\"\n";
                //$resultString = "{$resultString}{$nextSpaces}    \"Operation\": \"Removed\"\n";
                array_push($resultArray, "{$nextSpaces}{\n");
                array_push($resultArray, "{$nextSpaces}    \"Key\": \"{$keyOfStructure}\"\n");
                array_push($resultArray, "{$nextSpaces}    \"Operation\": \"Removed\"\n");
                if ($arr['children'] === null && !is_array($firstValueOfStructure)) {
                    $stringifyValue = typeValueToString($firstValueOfStructure);
                    if ($arr['secondValueType'] === 'string') {
                        //$resultString = "{$resultString}{$nextSpaces}    \"Value\": \"{$stringifyValue}\"\n";
                        array_push($resultArray, "{$nextSpaces}{\n");
                    } else {
                        //$resultString = "{$resultString}{$nextSpaces}    \"Value\": {$stringifyValue}\n";
                        array_push($resultArray, "{$nextSpaces}{\n");
                    }
                } elseif ($arr['children'] === null && is_array($firstValueOfStructure)) {
                    $childString = typeJsonNestedString($firstValueOfStructure, $nextNestedLvlAsArg);
                    //$resultString = "{$resultString}{$nextSpaces}    \"Value\": {$childString}\n";
                    array_push($resultArray, "{$nextSpaces}{\n");
                }
                //$resultString = "{$resultString}{$nextSpaces}}\n";
                array_push($resultArray, "{$nextSpaces}}\n");
                break;
            case 2:
                //$resultString = "{$resultString}{$nextSpaces}{\n";
                //$resultString = "{$resultString}{$nextSpaces}    \"Key\": \"{$keyOfStructure}\"\n";
                //$resultString = "{$resultString}{$nextSpaces}    \"Operation\": \"Added\"\n";
                array_push($resultArray, "{$nextSpaces}{\n");
                array_push($resultArray, "{$nextSpaces}    \"Key\": \"{$keyOfStructure}\"\n");
                array_push($resultArray, "{$nextSpaces}    \"Operation\": \"Added\"\n");
                if ($arr['children'] === null && !is_array($secondValueOfStructure)) {
                    $stringifyValue = typeValueToString($secondValueOfStructure);
                    if ($arr['secondValueType'] === 'string') {
                        //$resultString = "{$resultString}{$nextSpaces}    \"Value\": \"{$stringifyValue}\"\n";
                        array_push($resultArray, "{$nextSpaces}    \"Value\": \"{$stringifyValue}\"\n");
                    } else {
                        //$resultString = "{$resultString}{$nextSpaces}    \"Value\": {$stringifyValue}\n";
                        array_push($resultArray, "{$nextSpaces}    \"Value\": {$stringifyValue}\n");
                    }
                } elseif ($arr['children'] === null && is_array($secondValueOfStructure)) {
                    $childString = typeJsonNestedString($secondValueOfStructure, $nextNestedLvlAsArg);
                    //$resultString = "{$resultString}{$nextSpaces}    \"Value\": {$childString}\n";
                    array_push($resultArray, "{$nextSpaces}    \"Value\": {$childString}\n");
                }
                //$resultString = "{$resultString}{$nextSpaces}}\n";
                array_push($resultArray, "{$nextSpaces}}\n");
                break;
            case 3:
                $resultString = "{$resultString}{$nextSpaces}{\n";
                $resultString = "{$resultString}{$nextSpaces}    \"Key\": \"{$keyOfStructure}\"\n";
                $resultString = "{$resultString}{$nextSpaces}    \"Operation\": \"Unchanged\"\n";
                if ($arr['children'] === null) {
                    $stringifyValue = typeValueToString($firstValueOfStructure);
                    if ($arr['secondValueType'] === 'string') {
                        $resultString = "{$resultString}{$nextSpaces}    \"Value\": \"{$stringifyValue}\"\n";
                    } else {
                        $resultString = "{$resultString}{$nextSpaces}    \"Value\": {$stringifyValue}\n";
                    }
                } else {
                    $childString = jsonFormat($arr['children'], $nextNestedLvlAsArg);
                    $resultString = "{$resultString}{$nextSpaces}    \"Value\": {$childString}\n";
                }
                $resultString = "{$resultString}{$nextSpaces}}\n";
                break;
            case 4:
                $resultString = "{$resultString}{$nextSpaces}{\n";
                $resultString = "{$resultString}{$nextSpaces}    \"Key\": \"{$keyOfStructure}\"\n";
                $resultString = "{$resultString}{$nextSpaces}    \"Operation\": \"Changed\"\n";
                if ($arr['children'] === null) {
                    if (!is_array($firstValueOfStructure)) {
                        $stringifyValue = typeValueToString($firstValueOfStructure);
                        if ($arr['secondValueType'] === 'string') {
                            $resultString = "{$resultString}{$nextSpaces}    \"Old value\": \"{$stringifyValue}\"\n";
                        } else {
                            $resultString = "{$resultString}{$nextSpaces}    \"Old value\": {$stringifyValue}\n";
                        }
                    } else {
                        $childString = typeJsonNestedString($firstValueOfStructure, $nextNestedLvlAsArg);
                        $resultString = "{$resultString}{$nextSpaces}    \"Old value\": {$childString}\n";
                    }
                    if (!is_array($secondValueOfStructure)) {
                        $stringifyValue = typeValueToString($secondValueOfStructure);
                        if ($arr['secondValueType'] === 'string') {
                            $resultString = "{$resultString}{$nextSpaces}    \"New value\": \"{$stringifyValue}\"\n";
                        } else {
                            $resultString = "{$resultString}{$nextSpaces}    \"New value\": {$stringifyValue}\n";
                        }
                    } else {
                        $childString = typeJsonNestedString($secondValueOfStructure, $nextNestedLvlAsArg);
                        $resultString = "{$resultString}{$nextSpaces}    \"New value\": {$childString}\n";
                    }
                }
                $resultString = "{$resultString}{$nextSpaces}}\n";
                break;
        }
    }
    $resultString = "{$resultString}{$spaces}}";

    return $resultString;
}

function jsonFormat($arrayToOutAsString, $nestedLevel = 0)
{
    return json_encode($arrayToOutAsString, JSON_PRETTY_PRINT);
}
