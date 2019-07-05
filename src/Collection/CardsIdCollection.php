<?php


namespace TrelloCycleTime\Collection;


use TrelloCycleTime\ValueObject\CardId;

class CardsIdCollection
{
    /**
     * @var array
     */
    private $cardsId;

    public function __construct(array $cardsId)
    {
        $this->cardsId = $cardsId;
    }

    /**
     * @return array
     */
    public function getCardsId(): array
    {
        return $this->cardsId;
    }

    public static function createFromArray(array $cards) :CardsIdCollection
    {
        $cardsId = array_map(
            function ($card) {
                return CardId::createFromId($card['id']);
            },
            $cards
        );

        return new self($cardsId);
    }

    public static function createFromId(string $cardId) :CardsIdCollection
    {
        return new self([CardId::createFromId($cardId)]);
    }
}