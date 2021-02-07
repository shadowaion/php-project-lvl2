<?php

namespace php\project\lvl2\Formatters\Plain;

use function php\project\lvl2\src\Functions\typeValueToString;

function getValue1($firstValueOfStructure, $firstValueType, $currParRoute): string
{
    if (!is_array($firstValueOfStructure)) {
        $stringifyValue = typeValueToString($firstValueOfStructure);
        if ($firstValueType === 'string') {
            return "Property '{$currParRoute}' was updated. From '{$stringifyValue}' ";
        } else {
            return "Property '{$currParRoute}' was updated. From {$stringifyValue} ";
        }
    } else {
        return "Property '{$currParRoute}' was updated. From [complex value] ";
    }
}

function getValue2($secondValueOfStructure, $secondValueType): string
{
    if (!is_array($secondValueOfStructure)) {
        $stringifyValue = typeValueToString($secondValueOfStructure);
        if ($secondValueType === 'string') {
            return "to '{$stringifyValue}'\n";
        } else {
            return "to {$stringifyValue}\n";
        }
    } else {
        return "to [complex value]\n";
    }
}

function plain($arrayToOutAsString, $parentsRoute = ''): string
{
    $resultArray = array_map(function ($arr) use ($parentsRoute): string {
        $keyOfStructure = $arr['key'];
        $firstValueOfStructure = $arr['firstArrValue'];
        $secondValueOfStructure = $arr['secondArrValue'];

        $currentParentsRoute = $parentsRoute === '' ? $keyOfStructure : "{$parentsRoute}.{$keyOfStructure}";

        switch ($arr['cmpResult']) {
            case 1:
                if ($arr['children'] === null && !is_array($firstValueOfStructure)) {
                    return "Property '{$currentParentsRoute}' was removed\n";
                } elseif ($arr['children'] === null && is_array($firstValueOfStructure)) {
                    return "Property '{$currentParentsRoute}' was removed\n";
                }
                break;
            case 2:
                if ($arr['children'] === null && !is_array($secondValueOfStructure)) {
                    $stringifyValue = typeValueToString($secondValueOfStructure);
                    if ($arr['secondValueType'] === 'string') {
                        $line = "Property '{$currentParentsRoute}' was added with value: '{$stringifyValue}'\n";
                        return $line;
                    } else {
                        return "Property '{$currentParentsRoute}' was added with value: {$stringifyValue}\n";
                    }
                } elseif ($arr['children'] === null && is_array($secondValueOfStructure)) {
                    return "Property '{$currentParentsRoute}' was added with value: [complex value]\n";
                }
                break;
            case 3:
                if ($arr['children'] !== null) {
                    $childString = plain($arr['children'], $currentParentsRoute);
                    return "{$childString}\n";
                }
                break;
            case 4:
                if ($arr['children'] === null) {
                    $partOne = getValue1($firstValueOfStructure, $arr['firstValueType'], $currentParentsRoute);
                    $secondPart = getValue2($secondValueOfStructure, $arr['secondValueType']);
                    return "{$partOne}{$secondPart}";
                }
                break;
        }
        return '';
    }, $arrayToOutAsString);

    $resultString = implode('', $resultArray);

    $trimmedResult = rtrim($resultString);

    return $trimmedResult;
}
