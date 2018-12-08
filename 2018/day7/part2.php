<?php

require '../core.php';
require 'core.php';

function getPartResult($storageName)
{
    $instructions = Day7\getInstructionsFromStorage($storageName);

    $core = new Day7\Core($instructions);

    $seconds = 0;
    do {
        $core->plusSecond();

        do {
            if (($freeWorker = $core->getFreeWorker()) && ($readyStep = $core->getNextStep())) {

                $freeWorker->workOn = $readyStep;
                $freeWorker->seconds = $readyStep->duration;
                $readyStep->processedBy = $freeWorker;
            } else {
                break;
            }

        } while (true);

//        dump("second: $seconds => {$core->dumpWorkers()}");

        $seconds++;

    } while (!$core->isAllWorkersFree());

    return $seconds - 1;
}

$tests = [
    [
        'storage' => 'test_instructions',
        'result' => 15,
    ],
];

runTests($tests);

$result = getPartResult('test_instructions');
print "Result: $result" . PHP_EOL;
