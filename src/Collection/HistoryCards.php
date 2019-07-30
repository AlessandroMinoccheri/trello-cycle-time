<?php

declare(strict_types=1);

namespace TrelloCycleTime\Collection;

use TrelloCycleTime\Client\TrelloApiClient;
use TrelloCycleTime\Filter;
use TrelloCycleTime\ValueObject\HistoryCard;

class HistoryCards
{
    private $cardHistories;
    /**
     * @var Filter
     */
    private $filter;

    private function __construct(TrelloApiClient $client, array $cardsId, Filter $filter)
    {
        $this->cardHistories = [];
        $creationCards = [];
        $historyCards = [];
        $this->filter = $filter;

        foreach ($cardsId as $cardId) {
            sleep(5);

            $creationCard = $client->findCreationCard($cardId->getId());
            $creationCards = array_merge($creationCards, $creationCard);

            $historyCard = $client->findAllCardHistory($cardId->getId());
            $historyCards = array_merge($historyCards, $historyCard);
        }

        $this->createFromArray($historyCards);
        $this->addCreationCards($creationCards);
    }

    public static function createFromCards(TrelloApiClient $client, array $cards, Filter $filter)
    {
        return new self($client, $cards, $filter);
    }

    private function createFromArray(array $cardHistoryData)
    {
        foreach ($cardHistoryData as $histories) {
            if ([] === $histories) {
                continue;
            }

            $this->addHistoryCard(HistoryCard::createFromArray($histories));
        }
    }

    private function addCreationCards(array $cardCreationData)
    {
        foreach ($cardCreationData as $creation) {
            if ([] === $creation) {
                continue;
            }

            $this->addHistoryCard(HistoryCard::createFromCreationArray($creation));
        }
    }

    private function addHistoryCard(HistoryCard $historyCard) :void
    {
        if (!$this->isInFromDateRange($historyCard) || !$this->isInToDateRange($historyCard)) {
            return;
        }

        $this->cardHistories[] = $historyCard;
    }

    private function isInFromDateRange(HistoryCard $historyCard) :bool
    {
        if ($this->filter->isFromDateEnabled()) {
            if ($this->filter->getFromDate() === null) {
                return false;
            }

            if (strtotime($historyCard->getDate()) < strtotime($this->filter->getFromDate() ?? '1970-01-01')) {
                return false;
            }
        }

        return true;
    }

    private function isInToDateRange(HistoryCard $historyCard) :bool
    {
        if ($this->filter->isToDateEnabled()) {
            if ($this->filter->getToDate() === null) {
                return false;
            }

            if (strtotime($historyCard->getDate()) > strtotime($this->filter->getToDate() ?? '1970-01-01')) {
                return false;
            }
        }

        return true;
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