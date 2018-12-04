<?php

require '../core.php';
require 'core.php';

function getPartResult($storageName)
{
    $periods = getPeriods($storageName);

    $minutesStatisticsByGuards = [];
    foreach ($periods as $period) {
        $guardId = $period['guardId'];
        $start = $period['startDateTime'];
        $end = $period['endDateTime'];

        foreach (range($start->format('i'), $end->format('i') - 1) as $minute) {
            $minutesStatisticsByGuards[$guardId][$minute] = ($minutesStatisticsByGuards[$guardId][$minute] ?? 0) + 1;
        }
    }

    $maxTimes = 0;
    $foundGuardId = null;
    foreach ($minutesStatisticsByGuards as $quardId => $quardMinutesStatistics) {
        $quardMaxTimes = max($quardMinutesStatistics);
        if ($quardMaxTimes > $maxTimes) {
            $foundGuardId = $quardId;
            $maxTimes = $quardMaxTimes;
        }
    }

    $foundMinute = array_search($maxTimes, $minutesStatisticsByGuards[$foundGuardId]);

    return $foundGuardId * $foundMinute;
}

$tests = [
    [
        'storage' => 'test_records',
        'result' => 4455,
    ],
];

runTests($tests);

$result = getPartResult('real_records');
print "Result: $result" . PHP_EOL;
