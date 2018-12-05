<?php

require '../core.php';
require 'core.php';

function removeUnit($units, $aUnit)
{
    $aLowcase = strtolower($aUnit);
    $aUppercase = strtoupper($aUnit);

    foreach ($units as $unitKey => $unit) {

        if (($unit === $aLowcase) || ($unit === $aUppercase)) {
            unset($units[$unitKey]);
        }
    }

    return $units;
}

function getPartResult($storageName)
{
    $units = getUnitsFromStorage($storageName);

    $counts = [
        'a' => 0,
        'b' => 0,
        'c' => 0,
        'd' => 0,
    ];

    foreach ($counts as $unit => &$count) {
        $count = getReactedPolymerLength(removeUnit($units, $unit));
    }

    return min($counts);
}

$tests = [
    [
        'storage' => 'test_units',
        'result' => 4,
    ],
];

runTests($tests);

$result = getPartResult('real_units');
print "Result: $result" . PHP_EOL;
