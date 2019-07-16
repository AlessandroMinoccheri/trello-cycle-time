<?php

namespace Tests\Collection;


use PHPUnit\Framework\TestCase;
use TrelloCycleTime\Collection\CycleTimesCollection;
use TrelloCycleTime\ValueObject\HistoryCard;

class CycleTimeCollectionTest extends TestCase
{
    private $cycleTimeCollection;

    public function setUp()
    {
        $this->cycleTimeCollection = new CycleTimesCollection();
    }

    public function testGetAllCycleTimeColumnsWithEmptyData()
    {
        $cycleTime = $this->cycleTimeCollection->getFromCardHistory([]);

        $this->assertEquals([], $cycleTime);
    }

    public function testGetAllCycleTimeColumns()
    {
        $from = 'from';
        $to = 'to';

        $cardHistory = $this->prophesize(HistoryCard::class);
        $cardHistory->getFrom()->willReturn($from);
        $cardHistory->getTo()->willReturn($to);

        $cardHistory2 = $this->prophesize(HistoryCard::class);
        $cardHistory2->getFrom()->willReturn($from);
        $cardHistory2->getTo()->willReturn($to);

        $cardHistories = [
            $cardHistory->reveal(),
            $cardHistory->reveal(),
            $cardHistory2->reveal()
        ];

        $cycleTimes = $this->cycleTimeCollection->getFromCardHistory($cardHistories);

        $this->assertCount(1, $cycleTimes);

        foreach ($cycleTimes as $cycleTimeColumn) {
            $this->assertEquals('from', $cycleTimeColumn->getFrom());
            $this->assertEquals('to', $cycleTimeColumn->getTo());
            $this->assertEquals('from_to', $cycleTimeColumn->getName());
        }
    }
}