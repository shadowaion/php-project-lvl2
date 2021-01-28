<?php

namespace php\project\lvl2\src\Differ;

require __DIR__ . './../vendor/autoload.php';

function toString($value)
{
     return trim(var_export($value, true), "'");
}

function genDiff($pathToFile1, $pathToFile2)
{
    $resultString = '';

    $fileOneContent = file_get_contents($pathToFile1);
    $fileTwoContent = file_get_contents($pathToFile2);

    $fileOneArray = json_decode($fileOneContent, true);
    $fileTwoArray = json_decode($fileTwoContent, true);

    //echo "------var_dump of 1------\n";
    //var_dump($fileOneArray);
    //echo "------var_dump of 2------\n\n";
    //var_dump($fileTwoArray);

    $arrayMergedKeysArr = array_merge($fileOneArray, $fileTwoArray);
    ksort($arrayMergedKeysArr);

    $resultString .= "{\n";
    foreach ($arrayMergedKeysArr as $itemKey => $itemOne) {
        if (isset($fileOneArray[$itemKey]) && !isset($fileTwoArray[$itemKey])) {
            $itemValue = toString($fileOneArray[$itemKey]);
            $resultString .= "  - {$itemKey}: {$itemValue}\n";
        }
        if (!isset($fileOneArray[$itemKey]) && isset($fileTwoArray[$itemKey])) {
            $itemValue = toString($fileTwoArray[$itemKey]);
            $resultString .= "  + {$itemKey}: {$itemValue}\n";
        }
        if (isset($fileOneArray[$itemKey]) && isset($fileTwoArray[$itemKey])) {
            if ($fileOneArray[$itemKey] === $fileTwoArray[$itemKey]) {
                $itemValue = toString($fileOneArray[$itemKey]);
                $resultString .= "    {$itemKey}: {$itemValue}\n";
            } else {
                $itemValueOne = toString($fileOneArray[$itemKey]);
                $itemValueTwo = toString($fileTwoArray[$itemKey]);
                $resultString .= "  - {$itemKey}: {$itemValueOne}\n";
                $resultString .= "  + {$itemKey}: {$itemValueTwo}\n";
            }
        }
    }
    $resultString .= "}";

    return $resultString;
}
