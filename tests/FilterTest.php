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
}