<?php

namespace php\project\lvl2\src\Parsers;

use Symfony\Component\Yaml\Yaml;

function ConvertSTDObjectToArray($objToConvert)
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
    $fileParts = pathinfo($pathToFile);
    $fileContent = file_get_contents($pathToFile);

    if ($fileParts['extension'] === 'json') {
        $fileArray = json_decode($fileContent, true);
    }
    if ($fileParts['extension'] === 'yml') {
        $fileObj = Yaml::parse($fileContent, Yaml::PARSE_OBJECT_FOR_MAP);
        $fileArray = ConvertSTDObjectToArray($fileObj);
    }

    return $fileArray;
}
