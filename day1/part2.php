<?php

$input = trim(file_get_contents('input'));

$values = explode(PHP_EOL, $input);

$total = 0;
$totals = [0 => 1];

for ($k = 1; $k <= 1000; $k++) {
    foreach ($values as $value) {
        $total += $value;

        if (isset($totals[$total])) {
            print "Iteration: $k" . PHP_EOL;
            print "Result: $total" . PHP_EOL;

            break 2;
        }

        $totals[$total] = $total;
    }
}
