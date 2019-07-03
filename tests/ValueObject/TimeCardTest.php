<?php

namespace Tests\ValueObject;


use PHPUnit\Framework\TestCase;
use TrelloCycleTime\ValueObject\HistoryCard;
use TrelloCycleTime\ValueObject\TimeCard;

class TimeCardTest extends TestCase
{
    private $cardTime;
    private $id;
    private $title;
    private $from;
    private $to;
    private $cardHistory;

    public function setup()
    {
        $this->id = '1';
        $this->title = 'title';

        $this->from = 'from';
        $this->to = 'to';

        $this->cardHistory = $this->prophesize(HistoryCard::class);
        $this->cardHistory->getFrom()->willReturn('from');
        $this->cardHistory->getTo()->willReturn('to');

        $this->cardTime = TimeCard::create($this->id, $this->title);
    }

    public function testCreateCardTime()
    {
        $this->assertEquals($this->id, $this->cardTime->getId());
        $this->assertEquals($this->title, $this->cardTime->getTitle());
        $this->assertEquals([], $this->cardTime->getCycleTimes());
    }

    public function testSetCycleTimeColumnsByKey()
    {
        $this->cardTime->setCycleTimesByFromAndTo('from', 'to', 100);

        $cycleTime = $this->cardTime->getCycleTimesByFromAndTo('from', 'to');
        $this->assertEquals(100, $cycleTime);
    }
}