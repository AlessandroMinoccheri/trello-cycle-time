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
    /**
     * @var Filter
     */
    private $filter;

    public function __construct(TrelloApiClient $client, string $boardId)
    {
        $this->client = $client;
        $this->timeCards = new TimeCards();
        $this->boardId = $boardId;
    }

    public function getTransitions(array $filters = []) :array
    {
        $this->filter = Filter::createFromArray($filters);
        $cards = CardsIdCollection::createFromArray($this->client->findAllCards($this->boardId));

        $this->historyCardsCollection = HistoryCards::createFromCards($this->client, $cards->getCardsId(), $this->filter);

        return $this->calculateTimeCardsCycleTime();
    }

    public function getCardTransitions(string $cardId, array $filters = []) :array
    {
        $this->filter = Filter::createFromArray($filters);
        $cards = CardsIdCollection::createFromId($cardId);

        $this->historyCardsCollection = HistoryCards::createFromCards($this->client, $cards->getCardsId(), $this->filter);

        return $this->calculateTimeCardsCycleTime();
    }

    private function calculateTimeCardsCycleTime()
    {
        $timeCards = $this->timeCards->getFromHistoryCards($this->historyCardsCollection, $this->filter);

        $cycleTimeCalculator = new CycleTimeCalculator($timeCards, $this->historyCardsCollection);

        if ($this->filter->isFromColumnEnabled() && $this->filter->isToColumnEnabled()) {
            $cycleTimeCalculator->calculateWithStaticFromAndTo($this->filter->getFromColumn(), $this->filter->getToColumn());
        } else {
            $cycleTimeCalculator->calculateFromCardHistory();
        }

        return $cycleTimeCalculator->getTimeCards();
    }
}