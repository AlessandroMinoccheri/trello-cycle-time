<?php


namespace Tests\ValueObject;


use PHPUnit\Framework\TestCase;
use TrelloCycleTime\ValueObject\HistoryCard;
use TrelloCycleTime\ValueObject\CycleTime;

class CycleTimeColumnTest  extends TestCase
{
    public function testCreateFromCardHistory()
    {
        $from = 'fromColumn';
        $to = 'toColumn';

        $cardHistory = $this->prophesize(HistoryCard::class);
        $cardHistory->getFrom()->willReturn($from);
        $cardHistory->getTo()->willReturn($to);

        $cycleTimeColumn = CycleTime::createFromCardHistory($cardHistory->reveal());

        $this->assertEquals($from, $cycleTimeColumn->getFrom());
        $this->assertEquals($to, $cycleTimeColumn->getTo());
        $this->assertNull($cycleTimeColumn->getValue());
    }
}