<?php

require '../core.php';
require 'core.php';

function getPartResult($storageName)
{
    $core = new \Day8\Core($storageName);

    $numbers = $core->getNumbers();

    $node = $core->buildNode($numbers);

    return $core->calcMetadataTotal($node);
}

$tests = [
    [
        'storage' => 'test_tree',
        'result' => 138,
    ],
];

runTests($tests);

$result = getPartResult('real_tree');
print "Result: $result" . PHP_EOL;
