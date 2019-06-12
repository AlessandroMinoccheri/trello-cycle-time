<?php

declare(strict_types=1);

namespace TrelloCycleTime\Client;


use TrelloCycleTime\Client\Message\Response;
use TrelloCycleTime\Exception\RuntimeException;

class Client
{
    const GET_ALL_CARDS_URL = 'https://api.trello.com/1/boards/{boardId}/cards/?key={apiKey}&token={token}';

    const GET_CREATION_CARD_INFO_URL = 'https://api.trello.com/1/cards/{cardId}/actions?filter=createCard&key={apiKey}&token={token}';

    const GET_HISTORY_CARD_URL = 'https://api.trello.com/1/cards/{cardId}/actions?filter=updateCard:idList&key={apiKey}&token={token}';

    /**
     * @var string
     */
    private $apiKey;
    /**
     * @var string
     */
    private $token;
    /**
     * @var string
     */
    private $boardId;

    public function __construct(string $apiKey, string $token, string $boardId)
    {
        $this->apiKey = $apiKey;
        $this->token = $token;
        $this->boardId = $boardId;
    }

    public function findAllCards() :array
    {
        $url = $this->urlBuild(self::GET_ALL_CARDS_URL);

        return Response::validate($this->createRequest($url));
    }

    public function findCreationCard(string $cardId) :array
    {
        $url = $this->urlBuild(self::GET_CREATION_CARD_INFO_URL, $cardId);

        return Response::validate($this->createRequest($url));
    }

    public function findAllCardHistory(string $cardId) :array
    {
        $url = $this->urlBuild(self::GET_HISTORY_CARD_URL, $cardId);

        return Response::validate($this->createRequest($url));
    }

    private function createRequest(string $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT,5000);

        try {
            return curl_exec($ch);
        } catch (\Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    private function urlBuild($url, $cardId = null)
    {
        $placeholder = ['{boardId}', '{cardId}', '{apiKey}', '{token}'];
        $replaceWith   = [$this->boardId, $cardId, $this->apiKey, $this->token];

        return str_replace($placeholder, $replaceWith, $url);
    }
}