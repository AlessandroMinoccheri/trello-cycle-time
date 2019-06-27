<?php


namespace Tests\Client;

use PHPUnit\Framework\TestCase;
use TrelloCycleTime\Client\TrelloApiClient;

class TrelloApiClientTest extends TestCase
{
    public function testGetAllCards()
    {
        $trelloApiClient = new TrelloApiClientMock('apiKey', 'token');
        $response = $trelloApiClient->findAllCards('boardId');

        $this->assertEquals(
            [
                [
                    'foo' => 'bar'
                ]
            ], $response);
    }

    public function testFindCreationCards()
    {
        $trelloApiClient = new TrelloApiClientMock('apiKey', 'token');
        $response = $trelloApiClient->findCreationCard('cardId');

        $this->assertEquals(
            [
                [
                    'foo' => 'bar'
                ]
            ], $response);
    }

    public function testFindAllCardHistory()
    {
        $trelloApiClient = new TrelloApiClientMock('apiKey', 'token');
        $response = $trelloApiClient->findAllCardHistory('cardId');

        $this->assertEquals(
            [
                [
                    'foo' => 'bar'
                ]
            ], $response);
    }
}

class TrelloApiClientMock extends TrelloApiClient
{
    public function createRequest(string $url)
    {
        return '[{"foo":"bar"}]';
    }
}