<?php

declare(strict_types=1);

namespace TrelloCycleTime\Collection;

use TrelloCycleTime\Client\HttpClient;
use TrelloCycleTime\ValueObject\HistoryCard;

class HistoryCards
{
    private $cardHistories;

    private function __construct(HttpClient $client, array $cards)
    {
        $this->cardHistories = [];
        $creationCards = [];
        $historyCards = [];

        foreach ($cards as $card) {
            sleep(5);

            $creationCard = $client->findCreationCard($card['id']);

            $creationCards = array_merge($creationCards, $creationCard);

            $historyCard = $client->findAllCardHistory($card['id']);
            $historyCards = array_merge($historyCards, $historyCard);
        }

        $this->createFromArray($historyCards);
        $this->addCreationCards($creationCards);
    }

    public static function createFromCards(HttpClient $client, array $cards)
    {
        return new self($client, $cards);
    }

    private function createFromArray(array $cardHistoryData)
    {
        foreach ($cardHistoryData as $histories) {
            if ([] === $histories) {
                continue;
            }

            $cardHistory = HistoryCard::createFromArray($histories);
            $this->cardHistories[] = $cardHistory;
        }
    }

    private function addCreationCards(array $cardCreationData)
    {
        foreach ($cardCreationData as $creation) {
            if ([] === $creation) {
                continue;
            }

            $cardHistory = HistoryCard::createFromCreationArray($creation);
            $this->cardHistories[] = $cardHistory;
        }
    }

    /**
     * @param string $cardId
     * @param string $to
     * @return null|string
     */
    public function getByCardIdAndTo(string $cardId, string $to): ?string
    {
        foreach ($this->cardHistories as $history) {
            if ($cardId === $history->getId() && $to === $history->getTo()) {
                return $history->getDate();
            }
        }

        return null;
    }

    public function getCardHistories(): array
    {
        return $this->cardHistories;
    }
}