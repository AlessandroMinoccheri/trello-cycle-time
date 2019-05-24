<?php

namespace Tests;


use PHPUnit\Framework\TestCase;
use TrelloCycleTime\Column;
use TrelloCycleTime\ValueObject\HistoryCard;

class ColumnTest extends TestCase
{
    private $column;

    public function setUp()
    {
        $this->column = new Column();
    }

    public function testGetAllColumnsWithEmptyData()
    {
        $toColumns = $this->column->getAllToColumns([]);

        $this->assertEquals([], $toColumns);
    }

    public function testGetAllColumns()
    {
        $toColumn = 'toColumn';
        $toColumn2 = 'toColumn2';

        $cardHistory = $this->prophesize(HistoryCard::class);
        $cardHistory->getTo()->willReturn($toColumn);

        $cardHistory2 = $this->prophesize(HistoryCard::class);
        $cardHistory2->getTo()->willReturn($toColumn2);

        $cardHistories = [
            $cardHistory->reveal(),
            $cardHistory->reveal(),
            $cardHistory2->reveal()
        ];

        $toColumns = $this->column->getAllToColumns($cardHistories);

        $this->assertEquals([$toColumn, $toColumn2], $toColumns);
    }

    public function testGetAllCycleTimeColumnsWithEmptyData()
    {
        $cycleTimeColumns = $this->column->getAllCycleTimeColumns([]);

        $this->assertEquals([], $cycleTimeColumns);
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

        $cycleTimeColumns = $this->column->getAllCycleTimeColumns($cardHistories);

        $this->assertCount(3, $cycleTimeColumns);

        foreach ($cycleTimeColumns as $cycleTimeColumn) {
            $this->assertEquals('from', $cycleTimeColumn->getFrom());
            $this->assertEquals('to', $cycleTimeColumn->getTo());
            $this->assertEquals('from_to', $cycleTimeColumn->getName());
        }
    }
}