<?php

declare(strict_types=1);

namespace TrelloCycleTime\Collection;


use TrelloCycleTime\ValueObject\CycleTime;

class CycleTimesCollection
{
    private $cycleTimeCollection;

    public function __construct()
    {
        $this->cycleTimeCollection = [];
    }

    public function getFromCardHistory(array $cardHistories): array
    {
        foreach ($cardHistories as $history) {
            if ($history->getFrom() === null || $history->getFrom() === '') {
                continue;
            }
            
            $cycleTimeColumn = CycleTime::createFromCardHistory($history);
            if (!isset($this->cycleTimeCollection[$cycleTimeColumn->getName()])) {
                $this->cycleTimeCollection[$cycleTimeColumn->getName()] = $cycleTimeColumn;
            }
        }

        return $this->cycleTimeCollection;
    }
}