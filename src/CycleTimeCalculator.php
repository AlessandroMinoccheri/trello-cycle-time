<?php


namespace TrelloCycleTime;


use TrelloCycleTime\Collection\HistoryCards;
use TrelloCycleTime\ValueObject\HistoryCard;

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

    public function execute(HistoryCard $cardHistory)
    {
        foreach ($this->timeCards as $timeCard) {
            if ($timeCard->getId() !== $cardHistory->getId() ||
                $cardHistory->getFrom() === null ||
                $cardHistory->getTo() === null) {
                continue;
            }

            $fromDate = $this->historyCards->getByCardIdAndTo($timeCard->getId(), $cardHistory->getFrom());
            $toDate = $this->historyCards->getByCardIdAndTo($timeCard->getId(), $cardHistory->getTo());

            if ($fromDate === null || $toDate === null) {
                continue;
            }

            $timeCard->calculateDayDifferenceBetweenColumns(
                $cardHistory->getFrom(),
                $fromDate,
                $cardHistory->getTo(),
                $toDate
            );
        }
    }

    public function getTimeCards(): array
    {
        return $this->timeCards;
    }
}