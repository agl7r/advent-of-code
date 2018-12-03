<?php

function runTests(array $tests)
{
    foreach ($tests as $id => $test) {
        $testResult = getPartResult($test['storage']);
        if ($testResult === $test['result']) {
            print "Test №$id passed." . PHP_EOL;
        } else {
            print "Test №$id failed." . PHP_EOL;
        }
    }
}
