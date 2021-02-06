<?php

namespace php\project\lvl2\src\Parsers;

use Symfony\Component\Yaml\Yaml;

function ConvertSTDObjectToArray($objToConvert): array
{
    $convertedArray = get_object_vars($objToConvert);

    foreach ($convertedArray as $convKey => $convValue) {
        if (is_object($convValue)) {
            $convertedArray[$convKey] = ConvertSTDObjectToArray($convValue);
        }
    }

    return $convertedArray;
}

function parseFile($pathToFile)
{

    if (pathinfo($pathToFile)['extension'] === 'json') {
        return json_decode(file_get_contents($pathToFile), true);
    }
    if (pathinfo($pathToFile)['extension'] === 'yml' || pathinfo($pathToFile)['extension'] === 'yaml') {
        return ConvertSTDObjectToArray(Yaml::parse($fileContent, Yaml::PARSE_OBJECT_FOR_MAP));
    }

    return $fileArray;
}
