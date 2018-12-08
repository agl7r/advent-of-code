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

function dump($object)
{
    if (is_string($object)) {
        print $object . PHP_EOL;
    } else {
        print_r($object) . PHP_EOL;
    }
}
