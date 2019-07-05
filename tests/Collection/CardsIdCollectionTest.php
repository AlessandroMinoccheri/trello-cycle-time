<?php

namespace Tests\Collection;

use PHPUnit\Framework\TestCase;
use TrelloCycleTime\Client\TrelloApiClient;
use TrelloCycleTime\Collection\CardsIdCollection;
use TrelloCycleTime\Collection\HistoryCards;
use TrelloCycleTime\ValueObject\CardId;
use TrelloCycleTime\ValueObject\HistoryCard;

class CardsIdCollectionTest extends TestCase
{
    public function testCreateFromId()
    {
        $id = 'fooId';
        $cardsId = CardsIdCollection::createFromId($id);

        $this->assertEquals([CardId::createFromId($id)], $cardsId->getCardsId());
    }

    public function testCreateFromArray()
    {
        $id = 'fooId';

        $idArray = [
            [
                'id' => $id,
                'foo' => 'bar'
            ]
        ];

        $cardsId = CardsIdCollection::createFromArray($idArray);

        $this->assertEquals([CardId::createFromId($id)], $cardsId->getCardsId());
    }
}
