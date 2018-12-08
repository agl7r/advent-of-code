<?php

namespace Day8;

class Node
{
    public $metadata = [];
    public $children = [];
    public $length = 0;
}

class Core
{
    protected $numbers = [];

    public function __construct($storageName)
    {
        $this->numbers = $this->getInputNumbers($storageName);
    }

    public function getInputNumbers($storageName)
    {
        $storageFilePath = "data/$storageName.txt";

        $numbers = explode(' ', trim(file_get_contents($storageFilePath)));

        return $numbers;
    }

    public function getNumbers()
    {
        return $this->numbers;
    }

    public function buildNode(array $numbers)
    {
        $node = new Node;
        $offset = 2;

        $childNodesNumber = $numbers[0];
        $metadataEntriesNumber = $numbers[1];

        for ($i = 0; $i < $childNodesNumber; $i++) {
            $tailNumbers = array_slice($numbers, $offset);
            $childNode = $this->buildNode($tailNumbers);
            $offset += $childNode->length;
            $node->children[] = $childNode;
        }

        $metadataEntries = array_slice($numbers, $offset, $metadataEntriesNumber);
        $node->metadata = $metadataEntries;

        $offset += $metadataEntriesNumber;
        $node->length = $offset;

        return $node;
    }

    public function calcMetadataTotal(Node $node)
    {
        $sum = array_sum($node->metadata);

        foreach ($node->children as $childNode) {
            $sum += $this->calcMetadataTotal($childNode);
        }

        return $sum;
    }

    public function calcNodeTotal(Node $node)
    {
        $total = 0;

        if (empty($node->children)) {
            $total += array_sum($node->metadata);
        } else {
            foreach ($node->metadata as $key) {
                if (isset($node->children[$key - 1])) {
                    $total += $this->calcNodeTotal($node->children[$key - 1]);
                }
            }
        }

        return $total;
    }

}