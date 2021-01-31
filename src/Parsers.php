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
        $fileArray = json_decode($fileContent, true);
    }
    if ($fileParts['extension'] === 'yml') {
        $fileObj = Yaml::parse($fileContent, Yaml::PARSE_OBJECT_FOR_MAP);
        $fileArray = get_object_vars($fileObj);
    }

    return $fileArray;
}
