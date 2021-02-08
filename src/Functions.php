<?php

namespace php\project\lvl2\src\Functions;

use php\project\lvl2\src\Functions;

function typeValueToString($value): array
{
    if (!is_array($value)) {
        $result = trim(var_export($value, true), "'");
        if ($result === 'NULL') {
            return [strtolower($result)];
        }
        return [$result];
    }
    return [$value];
}
