<?php
/**
 * Created by PhpStorm.
 * User: alessandrominoccheri
 * Date: 2019-05-02
 * TimeCard: 08:09
 */

namespace TrelloCycleTime\ValueObject;


class CycleTime
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
     * @var string
     */
    private $value;
    /**
     * @var string
     */
    private $name;

    private function __construct(string $from, string $to, ?string $value, string $name)
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

    public static function createWithValue(string $from, string $to, string $value): CycleTime
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
     * @return string
     */
    public function getValue(): ?string
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
}