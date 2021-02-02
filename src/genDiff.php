<?php

namespace php\project\lvl2\src\Differ;

function typeValueToString($value)
{
     return trim(var_export($value, true), "'");
}

function typeNestedArrayAsString($arrayToType)
{
    $resultString = '';

    $resultString .= "{\n";
    foreach ($arrayMergedKeysArr as $itemKey => $itemOne) {

    }
    $resultString .= "}";
}

function genDiff($arrToOutAsString)
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
                $childArr = findDiff($parsedArrayOfFileOne[$itemKey], $parsedArrayOfFileTwo[$itemKey]);
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
