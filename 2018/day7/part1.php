<?php

require '../core.php';
require 'core.php';

function getPartResult($storageName)
{
    $instructions = Day7\getInstructionsFromStorage($storageName);

    $beforeToAfter = [];
    $steps = [];
    foreach ($instructions as $instruction) {
        list($before, $after) = Day7\parseSteps($instruction);

        $beforeToAfter[$before][] = $after;

        $steps[$before] = $before;
        $steps[$after] = $after;
    }

    foreach ($beforeToAfter as $afterSteps) {
        foreach ($afterSteps as $step) {
            unset($steps[$step]);
        }
    }

    $sequance = '';

    $m = [];

    foreach ($beforeToAfter as $step => $steps1) {
        foreach ($steps1 as $s) {
            $m[$s][] = $step;
        }
    }

    sort($steps);
    $current = array_shift($steps);
    $pool = array_values($steps);
    do {
        $sequance .= $current;

        foreach ($m as &$steps) {
            if (($key = array_search($current, $steps)) !== false) {
                unset($steps[$key]);
            }
        }

        if (isset($beforeToAfter[$current])) {
            $pool = array_merge($pool, $beforeToAfter[$current]);
        }

        $current = null;

        if (!empty($pool)) {
            $pool = array_unique($pool);
            sort($pool);

            do {
                $first = array_shift($pool);

                if (!empty($m[$first])) {
                    array_push($pool, $first);
                }

            } while (!empty($m[$first]));

            $current = $first;
        }

    } while ($current);

    return $sequance;
}

$tests = [
    [
        'storage' => 'test_instructions',
        'result' => 'CABDFE',
    ],
];

runTests($tests);

$result = getPartResult('real_instructions');
print "Result: $result" . PHP_EOL;
