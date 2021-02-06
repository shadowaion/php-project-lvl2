<?php

namespace Differ\Differ;

use php\project\lvl2\src\Parsers;
use php\project\lvl2\src\Formatters;

use function php\project\lvl2\src\Functions\typeValueToString;

function findDiff($parsedArrayOfFileOne, $parsedArrayOfFileTwo)
{
    $resultArr = [];

    $arrayMergedKeysArr = array_merge($parsedArrayOfFileOne, $parsedArrayOfFileTwo);
    ksort($arrayMergedKeysArr);
    foreach ($arrayMergedKeysArr as $itemKey => $itemOne) {
        if (array_key_exists($itemKey, $parsedArrayOfFileOne) && !array_key_exists($itemKey, $parsedArrayOfFileTwo)) {
            $resultArr[] = [
                "key" => $itemKey,
                "firstArrValue" => typeValueToString($parsedArrayOfFileOne[$itemKey]),
                "secondArrValue" => null,
                "firstValueType" => gettype($parsedArrayOfFileOne[$itemKey]),
                "secondValueType" => null,
                "children" => null,
                "cmpResult" => 1
            ];
        }
        if (!array_key_exists($itemKey, $parsedArrayOfFileOne) && array_key_exists($itemKey, $parsedArrayOfFileTwo)) {
            $resultArr[] = [
                "key" => $itemKey,
                "firstArrValue" => null,
                "secondArrValue" => typeValueToString($parsedArrayOfFileTwo[$itemKey]),
                "firstValueType" => null,
                "secondValueType" => gettype($parsedArrayOfFileTwo[$itemKey]),
                "children" => null,
                "cmpResult" => 2
            ];
        }
        if (array_key_exists($itemKey, $parsedArrayOfFileOne) && array_key_exists($itemKey, $parsedArrayOfFileTwo)) {
            if (is_array($parsedArrayOfFileOne[$itemKey]) && is_array($parsedArrayOfFileTwo[$itemKey])) {
                $childArr = findDiff($parsedArrayOfFileOne[$itemKey], $parsedArrayOfFileTwo[$itemKey]);
                $resultArr[] = [
                    "key" => $itemKey,
                    "firstArrValue" => typeValueToString($parsedArrayOfFileOne[$itemKey]),
                    "secondArrValue" => typeValueToString($parsedArrayOfFileTwo[$itemKey]),
                    "firstValueType" => gettype($parsedArrayOfFileOne[$itemKey]),
                    "secondValueType" => gettype($parsedArrayOfFileTwo[$itemKey]),
                    "children" => $childArr,
                    "cmpResult" => 3
                ];
            } elseif (!is_array($parsedArrayOfFileOne[$itemKey]) && !is_array($parsedArrayOfFileTwo[$itemKey])) {
                if ($parsedArrayOfFileOne[$itemKey] === $parsedArrayOfFileTwo[$itemKey]) {
                    $resultArr[] = [
                        "key" => $itemKey,
                        "firstArrValue" => typeValueToString($parsedArrayOfFileOne[$itemKey]),
                        "secondArrValue" => typeValueToString($parsedArrayOfFileTwo[$itemKey]),
                        "firstValueType" => gettype($parsedArrayOfFileOne[$itemKey]),
                        "secondValueType" => gettype($parsedArrayOfFileTwo[$itemKey]),
                        "children" => null,
                        "cmpResult" => 3
                    ];
                } else {
                    $resultArr[] = [
                        "key" => $itemKey,
                        "firstArrValue" => typeValueToString($parsedArrayOfFileOne[$itemKey]),
                        "secondArrValue" => typeValueToString($parsedArrayOfFileTwo[$itemKey]),
                        "firstValueType" => gettype($parsedArrayOfFileOne[$itemKey]),
                        "secondValueType" => gettype($parsedArrayOfFileTwo[$itemKey]),
                        "children" => null,
                        "cmpResult" => 4
                    ];
                }
            } else {
                $resultArr[] = [
                    "key" => $itemKey,
                    "firstArrValue" => typeValueToString($parsedArrayOfFileOne[$itemKey]),
                    "secondArrValue" => typeValueToString($parsedArrayOfFileTwo[$itemKey]),
                    "firstValueType" => gettype($parsedArrayOfFileOne[$itemKey]),
                    "secondValueType" => gettype($parsedArrayOfFileTwo[$itemKey]),
                    "children" => null,
                    "cmpResult" => 4
                ];
            }
        }
    }
    return $resultArr;
}

function genDiff($pathToFile1, $pathToFile2, $formatName = "stylish")
{
    $outputResult = '';

    $parsedFileOneArray = Parsers\parseFile($pathToFile1);
    $parsedFileTwoArray = Parsers\parseFile($pathToFile2);

    $genDiffArray = findDiff($parsedFileOneArray, $parsedFileTwoArray);

    $outputResult = Formatters\chooseFormatter($genDiffArray, $formatName);

    return $outputResult;
}
