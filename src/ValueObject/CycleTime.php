<?php

declare(strict_types=1);

namespace TrelloCycleTime\ValueObject;


class CycleTime implements \JsonSerializable
{
    /**
     * @var string
     */
    private $from;
    /**
     * @var string
     */
    private $to;
    /**
     * @var float
     */
    private $value;
    /**
     * @var string
     */
    private $name;

    private function __construct(string $from, string $to, ?float $value, string $name)
    {
        $this->from = $from;
        $this->to = $to;
        $this->value = $value;
        $this->name = $name;
    }

    public static function createFromCardHistory(HistoryCard $cardHistory): CycleTime
    {
        $from = $cardHistory->getFrom();
        $to = $cardHistory->getTo();
        $name = $from . '_' . $to;
        $value = null;

        return new self($from, $to, $value, $name);
    }

    public static function createWithValue(string $from, string $to, float $value): CycleTime
    {
        $name = $from . '_' . $to;

        return new self($from, $to, $value, $name);
    }

    /**
     * @return string
     */
    public function getFrom(): string
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
     * @return float
     */
    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(string $value)
    {
        return $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
            'from' => $this->from,
            'to' => $this->to,
            'value' => $this->value,
            'name' => $this->name
        ];
    }
}