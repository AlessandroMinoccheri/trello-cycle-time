<?php

namespace Tests\ValueObject;

use PHPUnit\Framework\TestCase;
use TrelloCycleTime\ValueObject\CardId;

class CardIdTest extends TestCase
{
    public function testCreateFromId()
    {
        $id = 'fooId';
        $cardId = CardId::createFromId($id);

        $this->assertEquals($id, $cardId->getId());

    }
}