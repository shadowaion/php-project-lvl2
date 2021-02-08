<?php

namespace php\project\lvl2\src\Parsers;

use Symfony\Component\Yaml\Yaml;

function ConvertSTDObjectToArray($objToConvert): array
{
    $convertedArray = get_object_vars($objToConvert);

    $keysArray = array_keys($convertedArray);
    $resultArray = array_map(function ($itemKey) use ($convertedArray): array {
        $itemValue = $convertedArray[$itemKey];

        if (is_object($itemValue)) {
            return [$itemKey => ConvertSTDObjectToArray($itemValue)];
        } else {
            return [$itemKey => $itemValue];
        }
    }, $keysArray);

    return array_merge([], ...$resultArray);

    // foreach ($convertedArray as $convKey => $convValue) {
    //     if (is_object($convValue)) {
    //         $convertedArray[$convKey] = ConvertSTDObjectToArray($convValue);
    //     }
    //     if (is_object($convValue)) {
    //         $convertedArray[] = [$convKey => ConvertSTDObjectToArray($convValue)];
    //     }
    // }

    // return $convertedArray;
}

function parseFile($pathToFile): array
{
    if ($pathToFile !== '') {
        $positionOfPoint = (int) strrpos($pathToFile, '.') + 1;
        $extention = substr($pathToFile, $positionOfPoint);
        if ($extention === 'json') {
            return json_decode(file_get_contents($pathToFile), true) ?? [];
        }
        if ($extention === 'yml' || $extention === 'yaml') {
            $contentOfFile = (string) file_get_contents($pathToFile);
            $resultOfParse = Yaml::parse($contentOfFile, Yaml::PARSE_OBJECT_FOR_MAP);
            return ConvertSTDObjectToArray($resultOfParse);
        }
    }

    return [];
}
