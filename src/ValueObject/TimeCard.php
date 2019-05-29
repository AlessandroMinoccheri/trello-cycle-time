<?php


namespace TrelloCycleTime\ValueObject;


class TimeCard
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
     * @return string|null
     */
    public function getCycleTimesByFromAndTo(string $fromKey, string $toKey) :?string
    {
        foreach ($this->cycleTimes as $cycleTime) {
            if ($cycleTime->getFrom() === $fromKey && $cycleTime->getTo() === $toKey) {
                return $cycleTime->getValue();
            }
        }

        return null;
    }

    public function setCycleTimesByFromAndTo(string $from, string $to, $value)
    {
        $cycleTime = CycleTime::createWithValue($from, $to, $value);
        $this->cycleTimes[] = $cycleTime;
        /*foreach ($this->cycleTimes as $cycleTime) {
            if ($cycleTime->getFrom() === $from && $cycleTime->getTo() === $to) {
                echo "\n title: ". $this->getTitle() . " from: ". $from . " to: " . $to . " value: " . $value .  " \n";
                return $cycleTime->setValue($value);
            }
        }*/
    }

    public function calculateDayDifferenceBetweenColumns(string $fromKey, string $from, string $toKey, string $to)
    {
        $dateDifference = strtotime($to) - strtotime($from);

        $dayDifference = round($dateDifference / (60 * 60 * 24));
        $this->setCycleTimesByFromAndTo($fromKey, $toKey, $dayDifference);
    }
}