<?php

namespace Tests\ValueObject;

use PHPUnit\Framework\TestCase;
use TrelloCycleTime\ValueObject\HistoryCard;

class CardHistoryTest extends TestCase
{
    public function testCreateFromArray()
    {
        $cardId = '1000';
        $name = 'name';
        $listBefore = 'listBefore';
        $listAfter = 'listAfter';
        $date = '2019-04-29 00:00:00';
        
        $data = [
            'data' => [
                'card' => [
                    'id' => $cardId,
                    'name' => $name,
                ],
                'listBefore' => [
                    'name' => $listBefore,
                ],
                'listAfter' => [
                    'name' => $listAfter,
                ]
            ],
            'date' =>  $date
        ];

        $cardHistory = HistoryCard::createFromArray($data);

        $this->assertEquals($cardId, $cardHistory->getId());
        $this->assertEquals($name, $cardHistory->getTitle());
        $this->assertEquals($listBefore, $cardHistory->getFrom());
        $this->assertEquals($listAfter, $cardHistory->getTo());
        $this->assertEquals($date, $cardHistory->getDate());

    }
}