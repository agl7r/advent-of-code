<?php

function getClaimsFromStorage($storageName)
{
    $storageFilePath = "data/$storageName.txt";

    if (!file_exists($storageFilePath)) {
        new \Exception('The storage file not found.');
    }

    $storageFileContents = trim(file_get_contents($storageFilePath));

    $claims = [];

    foreach (explode(PHP_EOL, $storageFileContents) as $line) {
        preg_match('/#(\d+) @ (\d+),(\d+): (\d+)x(\d+)/', $line, $matches);

        $claims[] = [
            'id' => $matches[1],
            'position' => [
                'top' => $matches[2],
                'left' => $matches[3],
            ],
            'size' => [
                'width' => $matches[5],
                'height' => $matches[4],
            ],
        ];
    }

    return $claims;
}
