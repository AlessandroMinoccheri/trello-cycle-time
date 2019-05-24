<?php


namespace TrelloCycleTime\ValueObject;


class Card
{
    private $id;

    private $title;

    private function __construct(string $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    public static function createFromArray(array $data) :Card
    {
        $id = $data['id'];
        $title = $data['name'];

        return new self($id, $title);
    }
}