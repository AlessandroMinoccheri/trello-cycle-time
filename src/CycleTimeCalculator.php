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
            if ($timeCard->getId() !== $cardHistory->getId()) {
                continue;
            }

            $from = $this->historyCards->getByCardIdAndTo($timeCard->getId(), $cardHistory->getFrom());
            $to = $this->historyCards->getByCardIdAndTo($timeCard->getId(), $cardHistory->getTo());

            if ($from === null || $to === null) {
                continue;
            }

            $timeCard->calculateDayDifferenceBetweenColumns(
                $cardHistory->getFrom(),
                $from,
                $cardHistory->getTo(),
                $to
            );
        }
    }

    public function getTimeCards() :array
    {
        return $this->timeCards;
    }
}