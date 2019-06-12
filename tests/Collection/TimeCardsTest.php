<?php


namespace Tests;


use PHPUnit\Framework\TestCase;
use TrelloCycleTime\Collection\HistoryCards;
use TrelloCycleTime\Collection\TimeCards;
use TrelloCycleTime\ValueObject\HistoryCard;

class TimeCardsTest extends TestCase
{
    public function testCreateCollectionWithNoData()
    {
        $historyCards = $this->prophesize(HistoryCards::class);
        $historyCards->getCardHistories()->willReturn([]);

        $timeCards = new TimeCards();
        $timeCards = $timeCards->getFromHistoryCards($historyCards->reveal());

        $this->assertEquals([], $timeCards);
    }

    public function testCreateCollection()
    {
        $id = 1;
        $title = 'cardTitle';
        $from = 'from';
        $to = 'to';

        $historyCard = $this->prophesize(HistoryCard::class);
        $historyCard->getId()->willReturn($id);
        $historyCard->getTitle()->willReturn($title);
        $historyCard->getFrom()->willReturn($from);
        $historyCard->getTo()->willReturn($to);

        $historyCards = $this->prophesize(HistoryCards::class);
        $historyCards->getCardHistories()->willReturn([$historyCard->reveal()]);

        $timeCards = new TimeCards();
        $timeCards = $timeCards->getFromHistoryCards($historyCards->reveal());

        $this->assertCount(1, $timeCards);

        $this->assertEquals($id, $timeCards[0]->getId());
        $this->assertEquals($title, $timeCards[0]->getTitle());
        $this->assertEquals([], $timeCards[0]->getCycleTimes());
    }
}