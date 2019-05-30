<?php

declare(strict_types=1);

namespace TrelloCycleTime\Collection;

use TrelloCycleTime\ValueObject\HistoryCard;

class HistoryCards
{
    private $cardHistories;

    private function __construct(array $cardHistories)
    {
        $this->cardHistories = $cardHistories;

        return $this;
    }

    public static function createFromArray(array $cardHistoryData)
    {
        $cardHistories = [];
        foreach ($cardHistoryData as $histories) {
            if ([] === $histories) {
                continue;
            }

            $cardHistory = HistoryCard::createFromArray($histories);
            $cardHistories[] = $cardHistory;
        }

        return new self($cardHistories);
    }

    public function addCreationCards(array $cardCreationData)
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