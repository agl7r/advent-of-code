<?php

namespace Day7;

class Worker
{
    /**
     * @var Step
     */
    public $workOn;

    public $seconds;
}

class Step {

    public $name;

    /**
     * @var Worker
     */
    public $processedBy;

    public $pre = [];

    public $duration;
}

class Core
{
    /**
     * @var Step[]
     */
    protected $steps = [];

    /**
     * @var Worker[]
     */
    protected $workers = [];

    protected $letters = [];

    public function __construct(array $instructions)
    {
        $seconds = 1;
        $baseSeconds = count($instructions) < 10 ? 0 : 6;
        foreach (range('A', 'Z') as $letter) {
            $this->letters[$letter] = $baseSeconds + $seconds;
            $seconds++;
        }

        $this->createStepsFromInstructions($instructions);

        $workersCount = count($instructions) < 10 ? 2 : 5;
        for ($i = 1; $i <= $workersCount; $i++) {
            $this->workers[] = new Worker();
        }
    }

    public function createStepsFromInstructions(array $instructions)
    {
        foreach ($instructions as $instruction) {
            list($before, $name) = parseSteps($instruction);

            $step = isset($this->steps[$name])
                ? $this->steps[$name]
                : new Step();

            $step->name = $name;
            $step->pre[] = $before;
            $step->duration = $this->letters[$name];
            $this->steps[$name] = $step;

            $step = isset($this->steps[$before])
                ? $this->steps[$before]
                : new Step();
            $step->name = $before;
            $step->duration = $this->letters[$before];
            $this->steps[$before] = $step;
        }

        ksort($this->steps);
    }

    public function getBusyWorkers()
    {
        return array_filter($this->workers, function(Worker $worker) {
            return !empty($worker->workOn);
        });
    }

    public function getStepsInWork()
    {
        return array_map(function(Worker $worker) {
            return $worker->workOn;
        }, $this->getBusyWorkers());
    }

    public function getNextStep()
    {
        foreach ($this->steps as $step) {
            if (empty($step->pre) && !$step->processedBy) {
                return $step;
            }
        }
    }

    public function getFreeWorker()
    {
        foreach ($this->workers as $worker) {
            if (!$worker->seconds) {
                return $worker;
            }
        }
    }

    public function isAllWorkersFree()
    {
        $notBusy = true;

        foreach ($this->workers as $worker) {
            if ($worker->workOn) {
                $notBusy = false;
            }
        }

        return $notBusy;
    }

    public function plusSecond()
    {
        foreach ($this->workers as $worker) {
            if ($worker->seconds > 0) {
                $worker->seconds--;

                if ($worker->seconds == 0) {

                    $downStep = $worker->workOn;
                    foreach ($this->steps as $step) {
                        if (($key = array_search($downStep->name, $step->pre)) !== false) {
                            unset($step->pre[$key]);
                        }
                    }

                    $worker->workOn = null;
                }
            }
        }
    }

    public function dumpWorkers()
    {
        $output = '';

        $a = [];
        foreach ($this->workers as $worker) {
            $a[] = 'step: ' . ($worker->workOn ? $worker->workOn->name : '') . ", seconds: {$worker->seconds}";
        }
        $output .= implode(' | ', $a);

        return $output;
    }
}

function getInstructionsFromStorage($storageName)
{
    $storageFilePath = "data/$storageName.txt";

    if (!file_exists($storageFilePath)) {
        new \Exception('The storage file not found.');
    }

    $instructins = explode("\n", trim(file_get_contents($storageFilePath)));

    return $instructins;
}

function parseSteps($instruction)
{
    preg_match('/Step ([A-Z]) must be finished before step ([A-Z]) can begin./', $instruction, $matches);

    return [$matches[1], $matches[2]];
}
