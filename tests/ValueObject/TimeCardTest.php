<?php

namespace Tests\ValueObject;


use PHPUnit\Framework\TestCase;
use TrelloCycleTime\ValueObject\HistoryCard;
use TrelloCycleTime\ValueObject\TimeCard;
use TrelloCycleTime\ValueObject\CycleTime;

class TimeCardTest extends TestCase
{
    private $cardTime;
    private $id;
    private $title;
    private $from;
    private $to;

    public function setup()
    {
        $this->id = 1;
        $this->title = 'title';

        $this->from = 'from';
        $this->to = 'to';

        $cardHistory = $this->prophesize(HistoryCard::class);
        $cardHistory->getFrom()->willReturn('from');
        $cardHistory->getTo()->willReturn('to');

        $cycleTimeColumnKey = [
            CycleTime::createFromCardHistory($cardHistory->reveal())
        ];

        $this->cardTime = TimeCard::create($this->id, $this->title, $cycleTimeColumnKey);
    }

    public function testCreateCardTime()
    {
        $this->assertEquals($this->id, $this->cardTime->getId());
        $this->assertEquals($this->title, $this->cardTime->getTitle());
        $this->assertEquals([], $this->cardTime->getCycleTimes());
    }

    public function testSetCycleTimeColumnsByKey()
    {
        $this->cardTime->setCycleTimesByFromAndTo('fromKey', 'toKey', 'value');

        $cycleTime = $this->cardTime->getCycleTimesByFromAndTo('fromKey', 'toKey');
        $this->assertEquals('value', $cycleTime);
    }
}