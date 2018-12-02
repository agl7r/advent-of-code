<?php

function runTests(array $tests)
{
    foreach ($tests as $test) {
        $testResult = getPartResult($test['storage']);
        if ($testResult === $test['result']) {
            print "Test {$test['id']} passed." . PHP_EOL;
        } else {
            print "Test {$test['id']} failed." . PHP_EOL;
        }
    }
}