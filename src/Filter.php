<?php


namespace TrelloCycleTime;


class Filter
{
    private $fromColumn;
    private $toColumn;
    private $fromDate;
    private $toDate;

    private function __construct(array $filters)
    {
        $this->fromColumn = $filters['fromColumn'] ?? null;
        $this->toColumn = $filters['toColumn'] ?? null;
        $this->fromDate= $filters['fromDate'] ?? null;
        $this->toDate = $filters['toDate'] ?? null;
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

    public function isFromDateEnabled() :bool
    {
        return $this->fromDate !== null;
    }

    public function isToDateEnabled() :bool
    {
        return $this->toDate !== null;
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

    /**
     * @return string|null
     */
    public function getFromDate(): ?string
    {
        return $this->fromDate;
    }

    /**
     * @return string|null
     */
    public function getToDate(): ?string
    {
        return $this->toDate;
    }
}