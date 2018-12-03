<?php

require '../core.php';
require 'core.php';

function getPartResult($storageName)
{
    $boxesIds = getBoxesIdsFromStorage($storageName);

    $twosCount = 0;
    $threesCount = 0;

    foreach ($boxesIds as $boxId) {
        $stats = getBoxIdLettersStatistics($boxId);

        if (array_search(2, $stats) !== false) {
            $twosCount++;
        }

        if (array_search(3, $stats) !== false) {
            $threesCount++;
        }
    }

    return $twosCount * $threesCount;
}

$tests = [
    [
        'storage' => 'test_1_boxes_ids',
        'result' => 12,
    ],
];

runTests($tests);

$result = getPartResult('real_boxes_ids');
print "Result: $result" . PHP_EOL;