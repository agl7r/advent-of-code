<?php

class Point
{
    public $id;
    public $x;
    public $y;
    public $closest;

    public static function create($x, $y)
    {
        $point = new self();
        $point->x = (int)$x;
        $point->y = (int)$y;
        return $point;
    }
}

function getCoordinatesFromStorage($storageName)
{
    $storageFilePath = "data/$storageName.txt";

    if (!file_exists($storageFilePath)) {
        new \Exception('The storage file not found.');
    }

    $coordinates = [];

    $id = 0;
    foreach (explode("\n", (trim(file_get_contents($storageFilePath)))) as $line) {
        $id++;
        list($x, $y) = explode(',', $line);
        $point = Point::create($x, $y);
        $point->id = $id;
        $coordinates[$point->id] = $point;
    }

    return $coordinates;
}

function calculateMapSize(array $coordinates)
{
    $xCoordinates = array_map(function (Point $point) {
       return $point->x;
    }, $coordinates);

    $yCoordinates = array_map(function (Point $point) {
        return $point->y;
    }, $coordinates);

    return [
        Point::create(
            min($xCoordinates),
            min($yCoordinates)
        ),
        Point::create(
            max($xCoordinates),
            max($yCoordinates)
        ),
    ];
}

function createMap(array $coordinates)
{
    list($from, $to) = calculateMapSize($coordinates);

    $map = [];

    for ($x = $from->x; $x < $to->x; $x++) {
        for ($y = $from->y; $y < $to->y; $y++) {
            $map[] = Point::create($x, $y);
        }
    }

    return $map;
}

function getPathLength(Point $from, Point $to)
{
    return abs($from->x - $to->x) + abs($from->y - $to->y);
}