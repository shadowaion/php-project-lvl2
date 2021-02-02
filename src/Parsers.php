<?php

namespace php\project\lvl2\src\Parsers;

use Symfony\Component\Yaml\Yaml;

function typeValueToString($value)
{
     return trim(var_export($value, true), "'");
}

function ConvertSTDObjectToArray($objToConvert)
{
    $convertedArray = get_object_vars($objToConvert);

    foreach($convertedArray as $convKey => $convValue) {
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

        //$fileObj = json_decode($fileContent);
        //$fileArray = ConvertSTDObjectToArray($fileObj);
        //echo "\n--------------------------What is here JSON object---------------------------\n";
        //var_dump($fileObj);
        //echo "\n--------------------------What is here JSON array---------------------------\n";
        //var_dump($fileArray);
        
        $fileArray = json_decode($fileContent, true);

        echo "\n--------------------------What is here JSON real array---------------------------\n";
        var_dump($fileArray);
    }
    if ($fileParts['extension'] === 'yml') {
        $fileObj = Yaml::parse($fileContent, Yaml::PARSE_OBJECT_FOR_MAP);
        $fileArray = ConvertSTDObjectToArray($fileObj);

        //echo "\n--------------------------What is here YAML object---------------------------\n";
        //var_dump($fileObj);
        echo "\n--------------------------What is here YAML array---------------------------\n";
        var_dump($fileArray);

        $fileArray = get_object_vars($fileObj);
    }

    return $fileArray;
}
