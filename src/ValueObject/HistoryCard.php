<?php

declare(strict_types=1);

namespace TrelloCycleTime\ValueObject;

class HistoryCard
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $from;
    /**
     * @var string
     */
    private $to;
    /**
     * @var string
     */
    private $date;

    private function __construct(string $id, string $title, ?string $from, string $to, string $date)
    {
        $this->id = $id;
        $this->title = $title;
        $this->from = $from;
        $this->to = $to;
        $this->date = $date;
    }

    public static function createFromArray(array $data) :HistoryCard
    {
        $id = $data['data']['card']['id'];
        $title = $data['data']['card']['name'];
        $from = $data['data']['listBefore']['name'];
        $to = $data['data']['listAfter']['name'];
        $date = date('Y-m-d H:i:s', strtotime($data['date']));

        return new self($id, $title, $from, $to, $date);
    }

    public static function createFromCreationArray(array $data) :HistoryCard
    {
        $id = $data['data']['card']['id'];
        $title = $data['data']['card']['name'];
        $from = null;
        $to = $data['data']['list']['name'];
        $date = date('Y-m-d H:i:s', strtotime($data['date']));

        return new self($id, $title, $from, $to, $date);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getFrom(): ?string
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }
}