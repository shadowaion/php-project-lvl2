<?php

namespace php\project\lvl2\Formatters\Plain;

use function php\project\lvl2\src\Functions\typeValueToString;

function plain($arrayToOutAsString, $parentsRoute = ''): string
{
    $resultString = '';

    foreach ($arrayToOutAsString as $key => $arr) {
        $keyOfStructure = $arr['key'];
        $firstValueOfStructure = $arr['firstArrValue'];
        $secondValueOfStructure = $arr['secondArrValue'];
        $currentParentsRoute = "";

        $currentParentsRoute = empty($parentsRoute) ? $keyOfStructure : "{$parentsRoute}.{$keyOfStructure}";

        switch ($arr['cmpResult']) {
            case 1:
                if ($arr['children'] === null && !is_array($firstValueOfStructure)) {
                    $resultString .= "Property '{$currentParentsRoute}' was removed\n";
                } elseif ($arr['children'] === null && is_array($firstValueOfStructure)) {
                    $resultString .= "Property '{$currentParentsRoute}' was removed\n";
                }
                break;
            case 2:
                if ($arr['children'] === null && !is_array($secondValueOfStructure)) {
                    $stringifyValue = typeValueToString($secondValueOfStructure);
                    if ($arr['secondValueType'] === 'string') {
                        $line = "Property '{$currentParentsRoute}' was added with value: '{$stringifyValue}'\n";
                        $resultString .= $line;
                    } else {
                        $resultString .= "Property '{$currentParentsRoute}' was added with value: {$stringifyValue}\n";
                    }
                } elseif ($arr['children'] === null && is_array($secondValueOfStructure)) {
                    $resultString .= "Property '{$currentParentsRoute}' was added with value: [complex value]\n";
                }
                break;
            case 3:
                if ($arr['children'] !== null) {
                    $childString = plain($arr['children'], $currentParentsRoute);
                    $resultString .= "{$childString}\n";
                }
                break;
            case 4:
                if ($arr['children'] === null) {
                    if (!is_array($firstValueOfStructure)) {
                        $stringifyValue = typeValueToString($firstValueOfStructure);
                        if ($arr['firstValueType'] === 'string') {
                            $resultString .= "Property '{$currentParentsRoute}' was updated. From '{$stringifyValue}' ";
                        } else {
                            $resultString .= "Property '{$currentParentsRoute}' was updated. From {$stringifyValue} ";
                        }
                    } else {
                        $resultString .= "Property '{$currentParentsRoute}' was updated. From [complex value] ";
                    }
                    if (!is_array($secondValueOfStructure)) {
                        $stringifyValue = typeValueToString($secondValueOfStructure);
                        if ($arr['secondValueType'] === 'string') {
                            $resultString .= "to '{$stringifyValue}'\n";
                        } else {
                            $resultString .= "to {$stringifyValue}\n";
                        }
                    } else {
                        $resultString .= "to [complex value]\n";
                    }
                }
                break;
        }
    }

    $trimmedResult = rtrim($resultString);

    return $trimmedResult;
}
