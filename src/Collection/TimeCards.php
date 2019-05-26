<?php

namespace TrelloCycleTime\Collection;


use TrelloCycleTime\CycleTimeCalculator;
use TrelloCycleTime\ValueObject\HistoryCard;
use TrelloCycleTime\ValueObject\TimeCard;

class TimeCards
{
    private $timeCards;
    private $cycleTimeCollection;
    private $historyCards;
    private $cycleTimeCalculator;

    public function __construct(HistoryCards $historyCards)
    {
        $this->timeCards = [];

        $this->historyCards = $historyCards;
        $column = new CycleTimesCollection();

        $cardHistoryCollection = $historyCards->getCardHistories();

        $this->cycleTimeCollection = $column->get($cardHistoryCollection);

        foreach ($cardHistoryCollection as $cardHistory) {
            $this->createTimeCardIfNotExists($cardHistory);

            if ($cardHistory->getFrom() === null || $cardHistory->getTo() === null) {
                continue;
            }
        }

        $this->cycleTimeCalculator = new CycleTimeCalculator($this->timeCards, $this->historyCards);
    }

    public function getCardTimeData(): array
    {
        $cardHistoryCollection = $this->historyCards->getCardHistories();
        foreach ($cardHistoryCollection as $cardHistory) {
            $this->cycleTimeCalculator->execute($cardHistory);
        }

        return $this->cycleTimeCalculator->getTimeCards();
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
