<?php

namespace Day10;

class Position
{
    public $x;
    public $y;
}

class Velocity
{
    public $x;
    public $y;
}

class Star
{
    public $position;
    public $velocity;
}

class Core
{
    /**
     * @var Star[]
     */
    protected $stars;

    public function __construct($storageName)
    {
        $this->parseInitialData($storageName);
    }

    protected function parseInitialData($storageName)
    {
        $storageFilePath = "data/$storageName.txt";

        $lines = explode("\n", trim(file_get_contents($storageFilePath)));

        foreach ($lines as $line) {
            preg_match_all('/position=<(.*),(.*)> velocity=<(.*),(.*)>/', $line, $matches);

            $position = new Position();
            $position->x = (int)$matches[1][0];
            $position->y = (int)$matches[2][0];

            $velosity = new Velocity();
            $velosity->x = (int)$matches[3][0];
            $velosity->y = (int)$matches[4][0];

            $star = new Star();
            $star->position = $position;
            $star->velocity = $velosity;

            $this->stars[] = $star;
        }

    }

    public function play()
    {
        for ($seconds = 1; $seconds <= 50000; $seconds++) {
            foreach ($this->stars as $star) {
                $star->position->x += $star->velocity->x;
                $star->position->y += $star->velocity->y;
            }
            if ($this->printStars($seconds)) {
                break;
            }
        }
    }

    public function printStars($seconds)
    {
        $x = array_map(function (Star $star) {
            return $star->position->x;
        }, $this->stars);

        $y = array_map(function (Star $star) {
            return $star->position->y;
        }, $this->stars);

        $minX = min($x);
        $maxX = max($x);

        $minY = min($y);
        $maxY = max($y);

        $square = abs($maxX - $minX) * abs($maxY - $minY);

        if ($square <= 630) {
            print "second: $seconds" . PHP_EOL;

            $area = [];
            foreach (range($minY, $maxY) as $y) {
                foreach (range($minX, $maxX) as $x) {
                    $area[$y][$x] = ' ';
                }
            }

            foreach ($this->stars as $star) {
                $area[$star->position->y][$star->position->x] = '#';
            }

            foreach ($area as $line) {
                print '|' . implode('', $line) . '|' . PHP_EOL;
            }

            return 1;
        }

        return 0;
    }
}