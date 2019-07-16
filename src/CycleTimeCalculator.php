<?php

declare(strict_types=1);

namespace TrelloCycleTime;


use TrelloCycleTime\Collection\HistoryCards;
use TrelloCycleTime\ValueObject\TimeCard;

class CycleTimeCalculator
{
    /**
     * @var array
     */
    private $timeCards;
    /**
     * @var HistoryCards
     */
    private $historyCards;

    public function __construct(array $timeCards, HistoryCards $historyCards)
    {
        $this->timeCards = $timeCards;
        $this->historyCards = $historyCards;
    }

    public function calculateFromCardHistory()
    {
        $cardHistoryCollection = $this->historyCards->getCardHistories();
        foreach ($cardHistoryCollection as $cardHistory) {
            foreach ($this->timeCards as $timeCard) {
                if ($timeCard->getId() !== $cardHistory->getId() ||
                    $cardHistory->getFrom() === null ||
                    $cardHistory->getTo() === null) {

                    continue;
                }

                $this->execute($timeCard, $cardHistory->getFrom(), $cardHistory->getTo());
            }
        }
    }

    public function calculateWithStaticFromAndTo(?string $from, ?string $to)
    {
        if ($from === null || $to === null) {
            return;
        }

        foreach ($this->timeCards as $timeCard) {
            $this->execute($timeCard, $from, $to);
        }
    }

    private function execute(TimeCard $timeCard, string $from, string $to)
    {
        $fromDate = $this->historyCards->getByCardIdAndTo($timeCard->getId(), $from);
        $toDate = $this->historyCards->getByCardIdAndTo($timeCard->getId(), $to);

        if ($fromDate === null || $toDate === null) {
            return;
        }

        $timeCard->calculateDayDifferenceBetweenColumns($from, $fromDate, $to, $toDate);
    }

    public function getTimeCards(): array
    {
        return json_decode(json_encode($this->timeCards), true);
    }
}