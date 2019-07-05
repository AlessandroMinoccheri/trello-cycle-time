<?php

declare(strict_types=1);

namespace TrelloCycleTime;

use TrelloCycleTime\Client\TrelloApiClient;
use TrelloCycleTime\Collection\CardsIdCollection;
use TrelloCycleTime\Collection\HistoryCards;
use TrelloCycleTime\Collection\TimeCards;

final class TrelloBoard
{

    private $client;

    private $historyCardsCollection;

    private $timeCards;
    /**
     * @var string
     */
    private $boardId;

    public function __construct(TrelloApiClient $client, string $boardId)
    {
        $this->client = $client;
        $this->timeCards = new TimeCards();
        $this->boardId = $boardId;
    }

    public function getTransitions() :array
    {
        $cards = CardsIdCollection::createFromArray($this->client->findAllCards($this->boardId));

        $this->historyCardsCollection = HistoryCards::createFromCards($this->client, $cards->getCardsId());

        return $this->calculateTimeCardsCycleTime();
    }

    public function getCardTransitions(string $cardId) :array
    {
        $cards = CardsIdCollection::createFromId($cardId);

        $this->historyCardsCollection = HistoryCards::createFromCards($this->client, $cards->getCardsId());

        return $this->calculateTimeCardsCycleTime();
    }

    private function calculateTimeCardsCycleTime()
    {
        $timeCards = $this->timeCards->getFromHistoryCards($this->historyCardsCollection);

        $cycleTimeCalculator = new CycleTimeCalculator($timeCards, $this->historyCardsCollection);
        $cycleTimeCalculator->execute();


        return $cycleTimeCalculator->getTimeCards();
    }
}