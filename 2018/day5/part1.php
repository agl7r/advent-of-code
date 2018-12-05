<?php

require '../core.php';
require 'core.php';

function getPartResult($storageName)
{
    $units = getUnitsFromStorage($storageName);

    return getReactedPolymerLength($units);
}

$tests = [
    [
        'storage' => 'test_units',
        'result' => 10,
    ],
];

runTests($tests);

$result = getPartResult('real_units');
print "Result: $result" . PHP_EOL;
