<?php

require '../core.php';
require 'core.php';

function getPartResult($storageName)
{
    $coordinates = getCoordinatesFromStorage($storageName);

    $map = createMap($coordinates);

    $areasSizes = [];

    foreach ($map as $point) {
        $pathsToPoints = [];
        foreach ($coordinates as $coordinate) {
            $length = getPathLength($point, $coordinate);
            $pathsToPoints[$length][] = $coordinate->id;
        }
        ksort($pathsToPoints);
        $minLength = key($pathsToPoints);
        if (count($pathsToPoints[$minLength]) == 1) {
            $point->closest = $pathsToPoints[$minLength][0];
            $areasSizes[$point->closest] = ($areasSizes[$point->closest] ?? 0) + 1;
        }
    }

    list($from, $to) = calculateMapSize($coordinates);

    $xx = [$from->x, $to->x];
    $yy = [$from->y, $to->y];

    foreach ($map as $point) {
        if (in_array($point->x, $xx) || in_array($point->y, $yy)) {
            if ($point->closest && isset($areasSizes[$point->closest])) {
                unset($areasSizes[$point->closest]);
            }
        }
    }

    sort($areasSizes);

    return $areasSizes[count($areasSizes) - 1];
}

$tests = [
    [
        'storage' => 'test_coordinates',
        'result' => 17,
    ],
];

runTests($tests);

$result = getPartResult('real_coordinates');
print "Result: $result" . PHP_EOL;
