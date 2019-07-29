<?php

namespace Tests;


use PHPUnit\Framework\TestCase;
use TrelloCycleTime\Filter;

class FilterTest extends TestCase
{
    public function testWithEmptyValues()
    {
        $filtersArray = [];
        $filter = Filter::createFromArray($filtersArray);

        $this->assertFalse($filter->isFromColumnEnabled());
        $this->assertFalse($filter->isToColumnEnabled());
        $this->assertFalse($filter->isFromDateEnabled());
        $this->assertFalse($filter->isToDateEnabled());
    }

    public function testWithFromColumnToColumnFilters()
    {
        $filtersArray = [
            'fromColumn' => 'fromColumn',
            'toColumn' => 'toColumn'
        ];
        $filter = Filter::createFromArray($filtersArray);

        $this->assertTrue($filter->isFromColumnEnabled());
        $this->assertTrue($filter->isToColumnEnabled());

        $this->assertEquals('fromColumn', $filter->getFromColumn());
        $this->assertEquals('toColumn', $filter->getToColumn());
    }

    public function testWithFromDateToDateFilters()
    {
        $filtersArray = [
            'fromDate' => 'fromDate',
            'toDate' => 'toDate'
        ];
        $filter = Filter::createFromArray($filtersArray);

        $this->assertTrue($filter->isFromDateEnabled());
        $this->assertTrue($filter->isToDateEnabled());

        $this->assertEquals('fromDate', $filter->getFromDate());
        $this->assertEquals('toDate', $filter->getToDate());
    }
}