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

    private function __construct(string $from, string $to, ?string $value)
    {
        $this->from = $from;
        $this->to = $to;
        $this->value = $value;
    }

    public static function createFromCardHistory(HistoryCard $cardHistory): CycleTime
    {
        $from = $cardHistory->getFrom();
        $to = $cardHistory->getTo();
        $value = null;

        return new self($from, $to, $value);
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
}