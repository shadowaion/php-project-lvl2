<?php

namespace php\project\lvl2\src\Differ;

use php\project\lvl2\src\Parsers;
use php\project\lvl2\src\Formatters;

use function php\project\lvl2\src\Functions\typeValueToString;

function addArrayToResult($key, $firstValue, $secondValue, $children, $cmpResult)
{
    return [
        "key" => $key,
        "firstArrValue" => typeValueToString($firstValue),
        "secondArrValue" => $secondValue,
        "firstValueType" => gettype($firstValueType),
        "secondValueType" => gettype($secondValueType),
        "children" => $children,
        "cmpResult" => $cmpResult
    ];
}

function findDiff($parsedArrayOfFileOne, $parsedArrayOfFileTwo)
{
    $resultArr = [];

    $arrayMergedKeysArr = array_merge($parsedArrayOfFileOne, $parsedArrayOfFileTwo);
    ksort($arrayMergedKeysArr);
    foreach ($arrayMergedKeysArr as $itemKey => $itemOne) {
        if (array_key_exists($itemKey, $parsedArrayOfFileOne) && !array_key_exists($itemKey, $parsedArrayOfFileTwo)) {
            $resultArr[] = addArrayToResult($itemKey, $parsedArrayOfFileOne[$itemKey], null, null, 1);
        }
        if (!array_key_exists($itemKey, $parsedArrayOfFileOne) && array_key_exists($itemKey, $parsedArrayOfFileTwo)) {
            $resultArr[] = addArrayToResult($itemKey, null, $parsedArrayOfFileTwo[$itemKey], null, 2);
        }
        if (array_key_exists($itemKey, $parsedArrayOfFileOne) && array_key_exists($itemKey, $parsedArrayOfFileTwo)) {
            if (is_array($parsedArrayOfFileOne[$itemKey]) && is_array($parsedArrayOfFileTwo[$itemKey])) {
                $childArr = findDiff($parsedArrayOfFileOne[$itemKey], $parsedArrayOfFileTwo[$itemKey]);
                $resultArr[] = addArrayToResult($itemKey, $parsedArrayOfFileOne[$itemKey], $parsedArrayOfFileTwo[$itemKey], $childArr, 3);
            } elseif (!is_array($parsedArrayOfFileOne[$itemKey]) && !is_array($parsedArrayOfFileTwo[$itemKey])) {
                if ($parsedArrayOfFileOne[$itemKey] === $parsedArrayOfFileTwo[$itemKey]) {
                    $resultArr[] = $resultArr[] = addArrayToResult($itemKey, $parsedArrayOfFileOne[$itemKey], $parsedArrayOfFileTwo[$itemKey], null, 3);
                } else {
                    $resultArr[] = addArrayToResult($itemKey, $parsedArrayOfFileOne[$itemKey], $parsedArrayOfFileTwo[$itemKey], null, 4);
                }
            } else {
                $resultArr[] = addArrayToResult($itemKey, $parsedArrayOfFileOne[$itemKey], $parsedArrayOfFileTwo[$itemKey], null, 4);
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
