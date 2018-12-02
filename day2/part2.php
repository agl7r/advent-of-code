<?php

require '../core.php';
require 'core.php';

function getPartResult($storageName)
{
    $boxesIds = getBoxesIdsFromStorage($storageName);

    foreach ($boxesIds as $index => $boxId1) {
        foreach (array_slice($boxesIds, $index) as $boxId2) {
            if (getBoxesIdsDiffsCount($boxId1, $boxId2) === 1) {
                return getBoxesIdsIntersection($boxId1, $boxId2);
            }
        }
    }
}

$tests = [
    [
        'storage' => 'test_2_boxes_ids',
        'result' => 'fgij',
    ],
];

runTests($tests);

$result = getPartResult('real_boxes_ids');
print "Result: $result" . PHP_EOL;