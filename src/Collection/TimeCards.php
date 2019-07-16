<?php

declare(strict_types=1);

namespace TrelloCycleTime\Collection;


use TrelloCycleTime\ValueObject\HistoryCard;
use TrelloCycleTime\ValueObject\TimeCard;

class TimeCards
{
    private $timeCards;
    private $cycleTimeCollection;
    private $historyCards;
    private $cardHistoryCollection;

    public function __construct()
    {
        $this->timeCards = [];
    }

    public function getFromHistoryCards(HistoryCards $historyCards) :array
    {
        $this->historyCards = $historyCards;
        $this->cardHistoryCollection = $historyCards->getCardHistories();

        foreach ($this->cardHistoryCollection as $cardHistory) {
            $this->createTimeCardIfNotExists($cardHistory);
        }

        return $this->getCardTimeData();
    }

    public function getCardTimeData(): array
    {
        return $this->timeCards;
    }

    private function createTimeCardIfNotExists(HistoryCard $cardHistory) {
        if (!$this->existsCardTime($cardHistory->getId())) {
            $cycleTimeCollection = new CycleTimesCollection();
            $this->cycleTimeCollection = $cycleTimeCollection->getFromCardHistory($this->cardHistoryCollection);

            $this->timeCards[] = TimeCard::create(
                $cardHistory->getId(),
                $cardHistory->getTitle()
            );
        }
    }

    private function existsCardTime(string $id): bool
    {
        foreach ($this->timeCards as $cardTime) {
            if ($cardTime->getId() === $id) {
                return true;
            }
        }

        return false;
    }
}
