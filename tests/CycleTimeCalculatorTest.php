<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use TrelloCycleTime\Collection\HistoryCards;
use TrelloCycleTime\CycleTimeCalculator;
use TrelloCycleTime\ValueObject\HistoryCard;
use TrelloCycleTime\ValueObject\TimeCard;

class CycleTimeCalculatorTest extends TestCase
{
    private $historyCards;
    private $cycleTimeCalculator;

    public function setUp()
    {
        $this->historyCards = $this->prophesize(HistoryCards::class);
        $this->cycleTimeCalculator = new CycleTimeCalculator([], $this->historyCards->reveal());
    }

    public function testExecuteWithEmptyData()
    {
        $historyCard = $this->prophesize(HistoryCard::class);
        $this->cycleTimeCalculator->execute($historyCard->reveal());

        $this->assertEquals([], $this->cycleTimeCalculator->getTimeCards());
    }

    public function testExecute()
    {
        $cardId = 1;
        $fromKey = 'from';
        $toKey = 'to';
        $fromDate = '2019-05-25 00:00:00';
        $toDate = '2019-05-26 00:00:00';

        $historyCard = $this->prophesize(HistoryCard::class);
        $historyCard->getId()->willReturn($cardId);
        $historyCard->getFrom()->willReturn($fromKey);
        $historyCard->getTo()->willReturn($toKey);

        $timeCard = $this->prophesize(TimeCard::class);
        $timeCard->getId()->willReturn($cardId);
        $timeCard->calculateDayDifferenceBetweenColumns($fromKey, $fromDate, $toKey, $toDate)->shouldBeCalled();

        $this->historyCards->getByCardIdAndTo($cardId, $fromKey)->willReturn($fromDate);
        $this->historyCards->getByCardIdAndTo($cardId, $toKey)->willReturn($toDate);

        $timeCardsCollection = [
            $timeCard->reveal()
        ];

        $this->cycleTimeCalculator = new CycleTimeCalculator($timeCardsCollection, $this->historyCards->reveal());
        $this->cycleTimeCalculator->execute($historyCard->reveal());
    }
}