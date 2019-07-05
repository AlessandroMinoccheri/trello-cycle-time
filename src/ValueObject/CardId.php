<?php


namespace TrelloCycleTime\ValueObject;


class CardId
{
    /**
     * @var string
     */
    private $id;

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function createFromId(string $id) :CardId
    {
        return new self($id);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}