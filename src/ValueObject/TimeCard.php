<?php

declare(strict_types=1);

namespace TrelloCycleTime\ValueObject;


class TimeCard implements \JsonSerializable
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
     * @var array
     */
    private $cycleTimes;

    private function __construct(string $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
        $this->cycleTimes = [];
    }

    public static function create(
        string $cardId,
        string $cardTitle
    ): TimeCard
    {
        return new self($cardId, $cardTitle);
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
     * @return array
     */
    public function getCycleTimes(): array
    {
        return $this->cycleTimes;
    }

    /**
     * @param string $fromKey
     * @param string $toKey
     * @return float|null
     */
    public function getCycleTimesByFromAndTo(string $fromKey, string $toKey): ?float
    {
        foreach ($this->cycleTimes as $cycleTime) {
            if ($cycleTime->getFrom() === $fromKey && $cycleTime->getTo() === $toKey) {
                return $cycleTime->getValue();
            }
        }

        return null;
    }

    public function setCycleTimesByFromAndTo(string $from, string $to, float $value)
    {
        $this->cycleTimes[] = CycleTime::createWithValue($from, $to, $value);
    }

    public function calculateDayDifferenceBetweenColumns(
        string $fromKey,
        string $fromDate,
        string $toKey,
        string $toDate
    )
    {
        $dateDifference = strtotime($toDate) - strtotime($fromDate);

        $dayDifference = round($dateDifference / (60 * 60 * 24));
        $this->setCycleTimesByFromAndTo($fromKey, $toKey, $dayDifference);
    }


    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'cycleTimes' => $this->cycleTimes
        ];
    }
}