<?php

function getUnitsFromStorage($storageName)
{
    $storageFilePath = "data/$storageName.txt";

    if (!file_exists($storageFilePath)) {
        new \Exception('The storage file not found.');
    }

    $units = str_split(trim(file_get_contents($storageFilePath)));

    return $units;
}

function getOppositeUnit($unit)
{
    $lowcaseLetters = [
        'a',
        'b',
        'c',
        'd',
        'e',
        'f',
        'g',
        'h',
        'i',
        'j',
        'k',
        'l',
        'm',
        'n',
        'o',
        'p',
        'q',
        'r',
        's',
        't',
        'u',
        'v',
        'w',
        'x',
        'y',
        'z'
    ];

    $uppercaseLetters = [
        'A',
        'B',
        'C',
        'D',
        'E',
        'F',
        'G',
        'H',
        'I',
        'J',
        'K',
        'L',
        'M',
        'N',
        'O',
        'P',
        'Q',
        'R',
        'S',
        'T',
        'U',
        'V',
        'W',
        'X',
        'Y',
        'Z'
    ];

    $index = array_search($unit, $lowcaseLetters);

    if ($index !== false) {
        return $uppercaseLetters[$index];
    } else {
        $index = array_search($unit, $uppercaseLetters);
        return $lowcaseLetters[$index];
    }
}

function getReactedPolymerLength($units)
{
    do {
        $changed = 0;

        $prevUnit = null;
        $prevUnitKey = null;
        foreach ($units as $unitKey => $unit) {

            if ($unit === getOppositeUnit($prevUnit)) {

                unset($units[$unitKey]);
                unset($units[$prevUnitKey]);

                $changed++;

                break;
            }

            $prevUnit = $unit;
            $prevUnitKey = $unitKey;
        }

    } while ($changed > 0);

    return count($units);
}