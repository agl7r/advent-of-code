<?php

require '../core.php';
require 'core.php';

function getPartResult($storageName)
{
    $claims = getClaimsFromStorage($storageName);

    $cells = [];
    foreach ($claims as $claim) {

        $position = $claim['position'];
        $size = $claim['size'];

        for ($i = $position['left'] + 1; $i <= ($position['left'] + $size['width']); $i++) {
            for ($j = $position['top'] + 1; $j <= ($position['top'] + $size['height']); $j++) {
                $cells["$i-$j"][] = $claim['id'];
            }
        }
    }

    $overlapСells = array_filter($cells, function($claimsIds) {
        return count($claimsIds) > 1;
    });

    return count($overlapСells);
}

$tests = [
    [
        'storage' => 'test_claims',
        'result' => 4,
    ],
];

runTests($tests);

$result = getPartResult('real_claims');
print "Result: $result" . PHP_EOL;
