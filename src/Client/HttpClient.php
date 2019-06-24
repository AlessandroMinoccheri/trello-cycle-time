<?php

declare(strict_types=1);

namespace TrelloCycleTime\Client;


use TrelloCycleTime\Client\Message\Response;
use TrelloCycleTime\Exception\RuntimeException;
use GuzzleHttp\Client as GuzzleClient;

class HttpClient implements HttpClientInterface
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

    public function findAllCards(): array
    {
        $url = $this->urlBuilder(self::GET_ALL_CARDS_URL);

        return Response::validate($this->createRequest($url));
    }

    public function findCreationCard(string $cardId): array
    {
        $url = $this->urlBuilder(self::GET_CREATION_CARD_INFO_URL, $cardId);

        return Response::validate($this->createRequest($url));
    }

    public function findAllCardHistory(string $cardId): array
    {
        $url = $this->urlBuilder(self::GET_HISTORY_CARD_URL, $cardId);

        return Response::validate($this->createRequest($url));
    }

    public function createRequest(string $url)
    {
        try {
            $client = new GuzzleClient();
            $response = $client->request('GET', $url);

            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    protected function urlBuilder($url, $cardId = null)
    {
        $placeholder = ['{boardId}', '{cardId}', '{apiKey}', '{token}'];
        $replaceWith = [$this->boardId, $cardId, $this->apiKey, $this->token];

        return str_replace($placeholder, $replaceWith, $url);
    }
}