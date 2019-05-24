<?php

namespace TrelloCycleTime\Collection;


use TrelloCycleTime\Column;
use TrelloCycleTime\ValueObject\HistoryCard;
use TrelloCycleTime\ValueObject\TimeCard;

class TimeCards
{
    public $cardTime;
    private $toColumns;
    private $cycleTimeColumns;
    private $historyCards;

    public function __construct(HistoryCards $historyCards)
    {
        $this->historyCards = $historyCards;
        $column = new Column();

        $cardHistoryCollection = $historyCards->getCardHistories();

        $this->toColumns = $column->getAllToColumns($cardHistoryCollection);
        $this->cycleTimeColumns = $column->getAllCycleTimeColumns($cardHistoryCollection);
        $this->cardTime = [];

        foreach ($cardHistoryCollection as $cardHistory) {
            $this->createTimeCardIfNotExists($cardHistory);

            if ($cardHistory->getFrom() === null || $cardHistory->getTo() === null) {
                continue;
            }

            $this->calculateCycleTimes($cardHistory);
        }
    }

    private function createTimeCardIfNotExists(HistoryCard $cardHistory) {
        if (!$this->existsCardTime($cardHistory->getId())) {
            $this->cardTime[] = TimeCard::create(
                $cardHistory->getId(),
                $cardHistory->getTitle(),
                $this->cycleTimeColumns
            );
        }
    }

    private function existsCardTime(string $id): bool
    {
        foreach ($this->cardTime as $cardTime) {
            if ($cardTime->getId() === $id) {
                return true;
            }
        }

        return false;
    }

    public function getCardTimeData(): array
    {
        return $this->cardTime;
    }

    private function calculateCycleTimes(HistoryCard $cardHistory)
    {
        foreach ($this->cardTime as $cardTime) {
            if ($cardTime->getId() !== $cardHistory->getId()) {
                continue;
            }

            $from = $this->historyCards->getByCardIdAndTo($cardTime->getId(), $cardHistory->getFrom());
            $to = $this->historyCards->getByCardIdAndTo($cardTime->getId(), $cardHistory->getTo());

            if ($from === null || $to === null) {
                continue;
            }

            $cardTime->calculateDayDifferenceBetweenColumns(
                $cardHistory->getFrom(),
                $from,
                $cardHistory->getTo(),
                $to
            );
        }
    }
}
