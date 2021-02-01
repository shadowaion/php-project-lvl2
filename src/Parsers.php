<?php

namespace php\project\lvl2\src\Parsers;

use Symfony\Component\Yaml\Yaml;

function typeValueToString($value)
{
     return trim(var_export($value, true), "'");
}

function parseFile($pathToFile)
{
    $fileParts = pathinfo($pathToFile);
    $fileContent = file_get_contents($pathToFile);

    if ($fileParts['extension'] === 'json') {
        $fileObj = json_decode($fileContent);
        echo "\n--------------------------What is here JSON object---------------------------\n";
        var_dump($fileObj);
        //$fileArray = json_decode($fileContent, true);
    }
    if ($fileParts['extension'] === 'yml') {
        $fileObj = Yaml::parse($fileContent, Yaml::PARSE_OBJECT_FOR_MAP);
        echo "\n--------------------------What is here YAML object---------------------------\n";
        var_dump($fileObj);
        $fileArray = get_object_vars($fileObj);
    }

    var_dump($fileArray);
    return $fileArray;
}
