<?php

declare(strict_types=1);

namespace TrelloCycleTime;

use TrelloCycleTime\Client\HttpClient;
use TrelloCycleTime\Collection\HistoryCards;
use TrelloCycleTime\Collection\TimeCards;

final class TrelloCycleTime
{

    private $client;

    private $historyCardsCollection;

    private $timeCards;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
        $this->timeCards = new TimeCards();
    }

    public function getAll() :array
    {
        $cards = $this->client->findAllCards();

        $this->historyCardsCollection = HistoryCards::createFromCards($this->client, $cards);

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