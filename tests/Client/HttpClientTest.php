<?php


namespace Tests\Client;

use PHPUnit\Framework\TestCase;
use TrelloCycleTime\Client\HttpClient;

class HttpClientTest extends TestCase
{
    public function testGetAllCards()
    {
        $httpClient = new HttpClientMock('apiKey', 'token', 'boardId');
        $response = $httpClient->findAllCards();

        $this->assertEquals(
            [
                [
                    'foo' => 'bar'
                ]
            ], $response);
    }

    public function testFindCreationCards()
    {
        $httpClient = new HttpClientMock('apiKey', 'token', 'boardId');
        $response = $httpClient->findCreationCard('cardId');

        $this->assertEquals(
            [
                [
                    'foo' => 'bar'
                ]
            ], $response);
    }

    public function testFindAllCardHistory()
    {
        $httpClient = new HttpClientMock('apiKey', 'token', 'boardId');
        $response = $httpClient->findAllCardHistory('cardId');

        $this->assertEquals(
            [
                [
                    'foo' => 'bar'
                ]
            ], $response);
    }
}

class HttpClientMock extends HttpClient
{
    public function createRequest(string $url)
    {
        return '[{"foo":"bar"}]';
    }
}