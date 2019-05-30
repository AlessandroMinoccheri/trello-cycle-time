<?php

declare(strict_types=1);

namespace TrelloCycleTime\Repository;

use TrelloCycleTime\Client\Client;
use TrelloCycleTime\Client\Message\Response;

class CardRepository
{
    private $apiKey;
    private $token;
    /**
     * @var Client
     */
    private $client;

    public function __construct(string $apiKey, string $token, Client $client)
    {
        $this->apiKey = $apiKey;
        $this->token = $token;
        $this->client = $client;
    }

    public function findAllCardFromBoardId(string $boardId) :array
    {
        $url = 'https://api.trello.com/1/boards/' . $boardId .
            '/cards/?key=' . $this->apiKey .
            '&token=' . $this->token;

        return Response::validate($this->client->createRequest($url));
    }

    public function findCreationCard(string $cardId) :array
    {
        $url = 'https://api.trello.com/1/cards/' . $cardId . '/actions?filter=createCard&key='
            . $this->apiKey . '&token=' . $this->token;

        return Response::validate($this->client->createRequest($url));
    }

    public function findAllCardHistory(string $cardId) :array
    {
        $url = 'https://api.trello.com/1/cards/' . $cardId . '/actions?filter=updateCard:idList&key='
            . $this->apiKey . '&token=' . $this->token;

        return Response::validate($this->client->createRequest($url));
    }
}