<?php

require '../core.php';
require 'core.php';

function getPartResult($storageName)
{
    $periods = getPeriods($storageName);

    $totalDurationsByGuards = [];
    foreach ($periods as $period) {
        $totalDurationsByGuards[$period['guardId']] = ($totalDurationsByGuards[$period['guardId']] ?? 0) + $period['durationInMunutes'];
    }

    $maxDuration = max($totalDurationsByGuards);
    $foundGuard = array_search($maxDuration, $totalDurationsByGuards);

    $quardPeriods = array_filter($periods, function($period) use ($foundGuard) {
        return $period['guardId'] == $foundGuard;
    });

    $minutesStatistics = [];
    foreach ($quardPeriods as $period) {
        $start = $period['startDateTime'];
        $end = $period['endDateTime'];

        foreach (range($start->format('i'), $end->format('i') - 1) as $minute) {
            $minutesStatistics[$minute] = ($minutesStatistics[$minute] ?? 0) + 1;
        }
    }

    $maxTimes = max($minutesStatistics);
    $foundMinute = array_search($maxTimes, $minutesStatistics);

    return $foundMinute * $foundGuard;
}

$tests = [
    [
        'storage' => 'test_records',
        'result' => 240,
    ],
];

runTests($tests);

$result = getPartResult('real_records');
print "Result: $result" . PHP_EOL;
