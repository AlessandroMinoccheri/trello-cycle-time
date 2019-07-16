<?php

namespace Tests\Collection;

use PHPUnit\Framework\TestCase;
use TrelloCycleTime\Client\TrelloApiClient;
use TrelloCycleTime\Collection\HistoryCards;
use TrelloCycleTime\Filter;
use TrelloCycleTime\ValueObject\CardId;
use TrelloCycleTime\ValueObject\HistoryCard;

class HistoryCardsTest extends TestCase
{
    private $client;

    public function setup()
    {
        $this->client = $this->prophesize(TrelloApiClient::class);
    }

    public function testCreateWithoutResultsReturnEmptyArray()
    {
        $cardHistoryCollection = HistoryCards::createFromCards($this->client->reveal(), []);
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

        $cards = [
            CardId::createFromId($cardId)
        ];

        $data = [
            [
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

        $this->client->findCreationCard($cardId)->willReturn([]);
        $this->client->findAllCardHistory($cardId)->willReturn($data);
        $cardHistoryCollection = HistoryCards::createFromCards($this->client->reveal(), $cards);

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
        $histories = $cardHistoryCollection->getCardHistories();
        $this->assertEquals($expected, $histories);
    }
}
