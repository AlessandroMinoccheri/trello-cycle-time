<?php

namespace TrelloCycleTime;


use TrelloCycleTime\ValueObject\CycleTime;

class Column
{
    private $toColumns;

    private $cycleTimeColumns;

    private $cycleTimeColumnsName;

    public function __construct()
    {
        $this->toColumns = [];
        $this->cycleTimeColumns = [];
        $this->cycleTimeColumnsName = [];
    }

    public function getAllToColumns(array $cardHistories): array
    {
        foreach ($cardHistories as $history) {
            if (!in_array($history->getTo(), $this->toColumns)) {
                $this->toColumns[] = $history->getTo();
            }
        }

        return $this->toColumns;
    }

    public function getAllCycleTimeColumns(array $cardHistories): array
    {
        foreach ($cardHistories as $history) {
            if ($history->getFrom() !== null && $history->getFrom() !== '') {
                $cycleTimeColumn = CycleTime::createFromCardHistory($history);
                $name = $cycleTimeColumn->getFrom() . '_' . $cycleTimeColumn->getTo();
                if (!in_array($name, $this->cycleTimeColumnsName)) {
                    $this->cycleTimeColumns[] = $cycleTimeColumn;
                    $this->cycleTimeColumnsName[] = $name;
                }
            }
        }

        return $this->cycleTimeColumns;
    }
}