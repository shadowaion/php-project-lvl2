<?php

namespace php\project\lvl2\src\Differ;

function typeValueToString($value)
{
     return trim(var_export($value, true), "'");
}

function findDiff($parsedArrayOfFileOne, $parsedArrayOfFileTwo)
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
