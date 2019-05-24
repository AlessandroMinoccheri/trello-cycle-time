<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use TrelloCycleTime\Collection\HistoryCards;
use TrelloCycleTime\ValueObject\HistoryCard;

class HistoryCardsTest extends TestCase
{
    public function testCreateWithoutResultsReturnEmptyArray()
    {
        $cardHistoryCollection = HistoryCards::createFromArray([]);
        $this->assertEquals([], $cardHistoryCollection->getCardHistories());
    }

    public function testCreateReturnResults()
    {
        $cardId = '1000';
        $name = 'name';
        $listBefore = 'listBefore';
        $listAfter = 'listAfter';
        $date = '2019-04-29 00:00:00';
        $name2 = 'name2';
        $listBefore2 = 'listBefore2';
        $listAfter2 = 'listAfter2';
        $date2 = '2019-04-29 10:00:00';

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
                'date' =>  $date
            ],
            [
                'id' => $cardId,
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
                'date' =>  $date2
            ]
        ];

        $cardHistoryCollection = HistoryCards::createFromArray($data);

        $cardHistory = HistoryCard::createFromArray([
            'id' => $cardId,
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
        ]);

        $cardHistory2 = HistoryCard::createFromArray([
            'id' => $cardId,
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
            'date' =>  $date2
        ]);

        $expected = [$cardHistory, $cardHistory2];

        $this->assertEquals($expected, $cardHistoryCollection->getCardHistories());



    }
}