<?php


namespace TrelloCycleTime;


class Filter
{
    private $fromColumn;
    private $toColumn;

    private function __construct(array $filters)
    {
        $this->fromColumn = $filters['fromColumn'] ?? null;
        $this->toColumn = $filters['toColumn'] ?? null;
    }

    public static function createFromArray(array $filters) :Filter
    {
        return new self($filters);
    }

    public function isFromColumnEnabled() :bool
    {
        return $this->fromColumn !== null;
    }

    public function isToColumnEnabled() :bool
    {
        return $this->toColumn !== null;
    }

    /**
     * @return string|null
     */
    public function getFromColumn(): ?string
    {
        return $this->fromColumn;
    }

    /**
     * @return string|null
     */
    public function getToColumn(): ?string
    {
        return $this->toColumn;
    }
}