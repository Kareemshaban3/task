<?php

function Recurring(array $nums): int {
    $seen = [];
    foreach ($nums as $num) {
        if (isset($seen[$num])) {
            return $num;
        }
        $seen[$num] = true;
    }
    return -1;
}

echo Recurring([2, 5, 1, 2, 3, 5, 1]);
echo "\n";
echo Recurring([1, 2, 3, 4]);


function is(string $str): bool {
    $cleaned = strtolower(str_replace(' ', '', $str));

    return $cleaned === strrev($cleaned);
}

var_dump(is("Race car"));
var_dump(is("hello"));

