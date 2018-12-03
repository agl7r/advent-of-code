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

    $overlapClaimsIds = array_map(function(array $claim) {
        return $claim['id'];
    }, $claims);

    $overlapClaimsIds = array_combine($overlapClaimsIds, $overlapClaimsIds);

    foreach ($cells as $cell) {
        if (count($cell) > 1) {
            foreach ($cell as $claimId) {
                unset($overlapClaimsIds[$claimId]);
            }
        }
    }

    return !empty($overlapClaimsIds) ? reset($overlapClaimsIds) : null;
}

$result = getPartResult('real_claims');
print "Result: $result" . PHP_EOL;
