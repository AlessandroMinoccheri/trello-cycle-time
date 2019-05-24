<?php

namespace TrelloCycleTime;

use TrelloCycleTime\Client\Client;
use TrelloCycleTime\Collection\HistoryCards;
use TrelloCycleTime\Collection\TimeCards;

class TrelloCycleTime
{

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

    private $client;

    private $repository;

    public function __construct(string $apiKey, string $token, string $boardId)
    {
        $this->apiKey = $apiKey;
        $this->token = $token;
        $this->boardId = $boardId;
        $this->client = new Client();
        $this->repository = new Repository\CardRepository($apiKey, $token, $this->client);
    }

    public function getAll() :array
    {
        $cards = $this->repository->findAllCardFromBoardId($this->boardId);
        $creationCards = [];
        $historyCards = [];

        foreach ($cards as $card) {
            sleep(5);

            $creationCard = $this->repository->findCreationCard($card['id']);

            if ([] !== $creationCard) {
                $creationCards = array_merge($creationCards, $creationCard);
            }

            $historyCard = $this->repository->findAllCardHistory($card['id']);

            if ([] !== $historyCard) {
                $historyCards = array_merge($historyCards, $historyCard);
            }
        }

        $historyCardsCollection = HistoryCards::createFromArray($historyCards);
        $historyCardsCollection->addCreationCards($creationCards);

        $timeCards = new TimeCards($historyCardsCollection);

        return $timeCards->getCardTimeData();
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }
}