<?php

require '../core.php';
require 'core.php';

function getPartResult($storageName)
{
    $coordinates = getCoordinatesFromStorage($storageName);

    $map = createMap($coordinates);

    foreach ($map as $point) {
        $sum = 0;
        foreach ($coordinates as $coordinate) {
            $sum += getPathLength($point, $coordinate);
        }
        $point->closest = $sum;
    }

    $maxLength = count($coordinates) < 20 ? 32 : 10000;
    $inAreaMap = array_filter($map, function(Point $point) use ($maxLength) {
        return $point->closest < $maxLength;
    });

    return count($inAreaMap);
}

$tests = [
    [
        'storage' => 'test_coordinates',
        'result' => 16,
    ],
];

runTests($tests);

$result = getPartResult('real_coordinates');
print "Result: $result" . PHP_EOL;
