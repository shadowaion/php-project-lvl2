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

function jsonFormat($arrayToOutAsString, $nestedLevel = 0)
{
    return json_encode($arrayToOutAsString, JSON_PRETTY_PRINT);
}
