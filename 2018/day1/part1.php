<?php

$input = trim(file_get_contents('input'));

$values = explode(PHP_EOL, $input);

print 'Resutl: ' . array_sum($values) . PHP_EOL;
