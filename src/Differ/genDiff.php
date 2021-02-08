<?php

namespace Differ\Differ;

use php\project\lvl2\src\Parsers;
use php\project\lvl2\src\Formatters;

use function php\project\lvl2\src\Functions\typeValueToString;

// function immutableKeySort($arrayToSort, $compare = false, $p = 0) {
//     $n = count($list);
//     $tmp = null;
//     $i = 0;
    
//     if(!$compare){
//       $compare = function($a,$b){ return $a > $b; };
//     }
     
//     if( $n < 2 ) { return $list;}
    
//     $p = $p === 0 ? $n - 1 : $p - 1; 
    
//     while( $i <= $p - 1 ){ 
//       if($compare($list[$i],$list[$i+1])){
//         $tmp = $list[$i];
//         $list[$i] = $list[$i+1];
//         $list[$i+1] = $tmp;
//       }
//       $i++;
//     }
      
//     if ( $p === 1 ){ return $list;}
       
//     return immutableKeySort($list, $compare, $p);
// }

function findDiff($parsedArrayOfFileOne, $parsedArrayOfFileTwo): array
{
    $arrayMergedKeysArr = array_merge($parsedArrayOfFileOne, $parsedArrayOfFileTwo);
    /** @phpstan-ignore-next-line */
    ksort($arrayMergedKeysArr);
    $keysArray = array_keys($arrayMergedKeysArr);
    $resultArr = array_map(function ($itemKey) use ($parsedArrayOfFileOne, $parsedArrayOfFileTwo) {
        if (array_key_exists($itemKey, $parsedArrayOfFileOne) && !array_key_exists($itemKey, $parsedArrayOfFileTwo)) {
            [$firstValue] = typeValueToString($parsedArrayOfFileOne[$itemKey]);
            return [
                "key" => $itemKey,
                "firstArrValue" => $firstValue,
                "secondArrValue" => null,
                "firstValueType" => gettype($parsedArrayOfFileOne[$itemKey]),
                "secondValueType" => null,
                "children" => null,
                "cmpResult" => 1
            ];
        }
        if (!array_key_exists($itemKey, $parsedArrayOfFileOne) && array_key_exists($itemKey, $parsedArrayOfFileTwo)) {
            [$secondValue] = typeValueToString($parsedArrayOfFileTwo[$itemKey]);
            return [
                "key" => $itemKey,
                "firstArrValue" => null,
                "secondArrValue" => $secondValue,
                "firstValueType" => null,
                "secondValueType" => gettype($parsedArrayOfFileTwo[$itemKey]),
                "children" => null,
                "cmpResult" => 2
            ];
        }
        if (array_key_exists($itemKey, $parsedArrayOfFileOne) && array_key_exists($itemKey, $parsedArrayOfFileTwo)) {
            if (is_array($parsedArrayOfFileOne[$itemKey]) && is_array($parsedArrayOfFileTwo[$itemKey])) {
                [$firstValue] = typeValueToString($parsedArrayOfFileOne[$itemKey]);
                [$secondValue] = typeValueToString($parsedArrayOfFileTwo[$itemKey]);
                $childArr = findDiff($parsedArrayOfFileOne[$itemKey], $parsedArrayOfFileTwo[$itemKey]);
                return [
                    "key" => $itemKey,
                    "firstArrValue" => $firstValue,
                    "secondArrValue" => $secondValue,
                    "firstValueType" => gettype($parsedArrayOfFileOne[$itemKey]),
                    "secondValueType" => gettype($parsedArrayOfFileTwo[$itemKey]),
                    "children" => $childArr,
                    "cmpResult" => 3
                ];
            } elseif (!is_array($parsedArrayOfFileOne[$itemKey]) && !is_array($parsedArrayOfFileTwo[$itemKey])) {
                if ($parsedArrayOfFileOne[$itemKey] === $parsedArrayOfFileTwo[$itemKey]) {
                    [$firstValue] = typeValueToString($parsedArrayOfFileOne[$itemKey]);
                    [$secondValue] = typeValueToString($parsedArrayOfFileTwo[$itemKey]);
                    return [
                        "key" => $itemKey,
                        "firstArrValue" => $firstValue,
                        "secondArrValue" => $secondValue,
                        "firstValueType" => gettype($parsedArrayOfFileOne[$itemKey]),
                        "secondValueType" => gettype($parsedArrayOfFileTwo[$itemKey]),
                        "children" => null,
                        "cmpResult" => 3
                    ];
                } else {
                    [$firstValue] = typeValueToString($parsedArrayOfFileOne[$itemKey]);
                    [$secondValue] = typeValueToString($parsedArrayOfFileTwo[$itemKey]);
                    return [
                        "key" => $itemKey,
                        "firstArrValue" => $firstValue,
                        "secondArrValue" => $secondValue,
                        "firstValueType" => gettype($parsedArrayOfFileOne[$itemKey]),
                        "secondValueType" => gettype($parsedArrayOfFileTwo[$itemKey]),
                        "children" => null,
                        "cmpResult" => 4
                    ];
                }
            } else {
                [$firstValue] = typeValueToString($parsedArrayOfFileOne[$itemKey]);
                [$secondValue] = typeValueToString($parsedArrayOfFileTwo[$itemKey]);
                return [
                    "key" => $itemKey,
                    "firstArrValue" => $firstValue,
                    "secondArrValue" => $secondValue,
                    "firstValueType" => gettype($parsedArrayOfFileOne[$itemKey]),
                    "secondValueType" => gettype($parsedArrayOfFileTwo[$itemKey]),
                    "children" => null,
                    "cmpResult" => 4
                ];
            }
        }
        return [];
    }, $keysArray);
    // foreach ($arrayMergedKeysArr as $itemKey => $itemOne) {
    // }
    return $resultArr;
}

function genDiff($pathToFile1, $pathToFile2, $formatName = "stylish"): string
{
    $parsedFileOneArray = Parsers\parseFile($pathToFile1);
    $parsedFileTwoArray = Parsers\parseFile($pathToFile2);

    $genDiffArray = findDiff($parsedFileOneArray, $parsedFileTwoArray);

    $outputResult = Formatters\chooseFormatter($genDiffArray, $formatName);

    return $outputResult;
}
