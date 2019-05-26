<?php

namespace TrelloCycleTime\Collection;


use TrelloCycleTime\ValueObject\HistoryCard;
use TrelloCycleTime\ValueObject\TimeCard;

class TimeCards
{
    private $timeCards;
    private $cycleTimeCollection;
    private $historyCards;

    public function __construct(HistoryCards $historyCards)
    {
        $this->timeCards = [];

        $this->historyCards = $historyCards;
        $cardHistoryCollection = $historyCards->getCardHistories();

        $cycleTimeCollection = new CycleTimesCollection();
        $this->cycleTimeCollection = $cycleTimeCollection->get($cardHistoryCollection);

        foreach ($cardHistoryCollection as $cardHistory) {
            $this->createTimeCardIfNotExists($cardHistory);
        }
    }

    public function getCardTimeData(): array
    {
        return $this->timeCards;
    }

    private function createTimeCardIfNotExists(HistoryCard $cardHistory) {
        if (!$this->existsCardTime($cardHistory->getId())) {
            $this->timeCards[] = TimeCard::create(
                $cardHistory->getId(),
                $cardHistory->getTitle(),
                $this->cycleTimeCollection
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
