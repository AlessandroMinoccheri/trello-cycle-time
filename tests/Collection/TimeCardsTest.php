<?php


namespace Tests;


use PHPUnit\Framework\TestCase;
use TrelloCycleTime\Collection\HistoryCards;
use TrelloCycleTime\Collection\TimeCards;
use TrelloCycleTime\ValueObject\CycleTime;

class TimeCardsTest extends TestCase
{
    public function testCreateCollection()
    {
        $cardId = '1000';
        $name = 'name';
        $listBefore = '';
        $listAfter = 'ToDo';
        $date = '2019-04-29 00:00:00';
        $name2 = 'name2';
        $listBefore2 = 'ToDo';
        $listAfter2 = 'Doing';
        $date2 = '2019-05-05 10:00:00';

        $data = [
            [
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
                'date' => $date
            ],
            [
                'data' => [
                    'card' => [
                        'id' => $cardId,
                        'name' => $name2,
                    ],
                    'listBefore' => [
                        'name' => $listBefore2,
                    ],
                    'listAfter' => [
                        'name' => $listAfter2,
                    ]
                ],
                'date' => $date2
            ]
        ];

        $cardHistoryCollectionData = HistoryCards::createFromArray($data);

        $expected = [
            'ToDo_Doing' => 6
        ];

        $cycleTime = CycleTime::createFromCardHistory();

        $cardTimeCollection = new TimeCards($cardHistoryCollectionData);
        $cardTimes = $cardTimeCollection->getCardTimeData();

        $this->assertCount(1, $cardTimes);
        $this->assertEquals($expected, $cardTimes[0]->getCycleTimes());
    }
}