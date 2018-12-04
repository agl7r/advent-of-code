<?php

function getRecordsFromStorage($storageName)
{
    $storageFilePath = "data/$storageName.txt";

    if (!file_exists($storageFilePath)) {
        new \Exception('The storage file not found.');
    }

    $storageFileContents = trim(file_get_contents($storageFilePath));

    $lines = explode(PHP_EOL, $storageFileContents);
    sort($lines);

    $records = [];

    foreach ($lines as $line) {
        preg_match('/\[(.*)\]\s(.*)/', $line, $matches);

        $records[] = [
            'time' => $matches[1],
            'message' => trim($matches[2]),
        ];
    }

    return $records;
}

function getPeriods($storageName)
{
    $records = getRecordsFromStorage($storageName);

    $periods = [];
    $currentGuard = null;
    $startDateTime = null;
    foreach ($records as $key => $record) {

        $message = $record['message'];
        $recordDateTime = \DateTime::createFromFormat('Y-m-d H:i', $record['time']);

        preg_match_all('/Guard #(\d+) begins shift/', $record['message'], $matches);
        if (isset($matches[1][0])) {
            $currentGuard = $matches[1][0];
        } elseif ($message == 'falls asleep') {
            $startDateTime = clone $recordDateTime;
        } elseif ($message == 'wakes up') {

            $minutes = (($recordDateTime->getTimestamp() - $startDateTime->getTimestamp()) / 60) - 1;

            $periods[] = [
                'guardId' => $currentGuard,
                'durationInMunutes' => $minutes,
                'startDateTime' => $startDateTime,
                'endDateTime' => $recordDateTime,
            ];

            $startDateTime = null;
        }
    }

    return $periods;
}