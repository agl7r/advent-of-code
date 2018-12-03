<?php

function getBoxesIdsFromStorage($storageName)
{
    $storageFilePath = "data/$storageName.txt";

    if (!file_exists($storageFilePath)) {
        new \Exception('The storage file not found.');
    }

    $storageFileContents = trim(file_get_contents($storageFilePath));

    $boxesIds = explode(PHP_EOL, $storageFileContents);

    return $boxesIds;
}

function getBoxIdLettersStatistics($boxId)
{
    $idLetters = str_split($boxId);

    $statistics = array_count_values($idLetters);

    return $statistics;
}

function getBoxesIdsDiffsCount($box1Id, $box2Id)
{
    $letters1 = str_split($box1Id);
    $letters2 = str_split($box2Id);

    $diffsCount = 0;
    foreach ($letters1 as $position => $leller) {
        if ($letters1[$position] != $letters2[$position]) {
            $diffsCount++;
        }
    }

    return $diffsCount;
}

function getBoxesIdsIntersection($box1Id, $box2Id)
{
    $letters1 = str_split($box1Id);
    $letters2 = str_split($box2Id);

    $intersection = '';
    foreach ($letters1 as $position => $leller) {
        if ($letters1[$position] === $letters2[$position]) {
            $intersection .= $letters1[$position];
        }
    }

    return $intersection;
}