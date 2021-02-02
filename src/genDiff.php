<?php

namespace php\project\lvl2\src\Differ;

function typeValueToString($value)
{
     return trim(var_export($value, true), "'");
}

function findDiff($parsedArrayOfFileOne, $parsedArrayOfFileTwo)
{
    $resultArr = [];
    $resultString = '';

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

function genDiff($parsedArrayOfFileOne, $parsedArrayOfFileTwo)
{
    $resultString = '';

    //$parsedArrayOfFileOne = json_decode($fileOneContent, true);
    //$parsedArrayOfFileTwo = json_decode($fileTwoContent, true);

    //echo "------var_dump of 1------\n";
    //var_dump($parsedArrayOfFileOne);
    //echo "------var_dump of 2------\n\n";
    //var_dump($parsedArrayOfFileTwo);

    $arrayMergedKeysArr = array_merge($parsedArrayOfFileOne, $parsedArrayOfFileTwo);
    ksort($arrayMergedKeysArr);

    $resultString .= "{\n";
    foreach ($arrayMergedKeysArr as $itemKey => $itemOne) {
        if (isset($parsedArrayOfFileOne[$itemKey]) && !isset($parsedArrayOfFileTwo[$itemKey])) {
            $itemValue = typeValueToString($parsedArrayOfFileOne[$itemKey]);
            $resultString .= "  - {$itemKey}: {$itemValue}\n";
        }
        if (!isset($parsedArrayOfFileOne[$itemKey]) && isset($parsedArrayOfFileTwo[$itemKey])) {
            $itemValue = typeValueToString($parsedArrayOfFileTwo[$itemKey]);
            $resultString .= "  + {$itemKey}: {$itemValue}\n";
        }
        if (isset($parsedArrayOfFileOne[$itemKey]) && isset($parsedArrayOfFileTwo[$itemKey])) {
            if ($parsedArrayOfFileOne[$itemKey] === $parsedArrayOfFileTwo[$itemKey]) {
                $itemValue = typeValueToString($parsedArrayOfFileOne[$itemKey]);
                $resultString .= "    {$itemKey}: {$itemValue}\n";
            } else {
                $itemValueOne = typeValueToString($parsedArrayOfFileOne[$itemKey]);
                $itemValueTwo = typeValueToString($parsedArrayOfFileTwo[$itemKey]);
                $resultString .= "  - {$itemKey}: {$itemValueOne}\n";
                $resultString .= "  + {$itemKey}: {$itemValueTwo}\n";
            }
        }
    }
    $resultString .= "}";

    return $resultString;
}
