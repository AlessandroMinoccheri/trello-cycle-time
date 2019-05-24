<?php


namespace TrelloCycleTime\Collection;


use TrelloCycleTime\Client;

class Cards
{
    private $client;

    private $cards;

    public function __construct(string $url, Client $client)
    {
        $this->client = $client;

        $cardCollection = json_decode($this->client->createRequest($url), true);

        $this->cards = [];

        foreach ($cardCollection as $card) {
            //$cardHistory = HistoryCard::createFromArray($card);

            $this->cards[] = $cardHistory;
        }

        return $this;
    }
}