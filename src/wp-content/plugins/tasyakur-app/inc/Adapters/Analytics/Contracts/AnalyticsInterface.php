<?php
namespace Tasyakur\Adapters\Analytics\Contracts;

interface AnalyticsInterface
{
    /**
     * @param AnalyticsQuery $query
     * @return AnalyticsInterface
     */
    public function runQuery(AnalyticsQuery $query): self;

    /**
     * Returns an array of query result
     * @return array
     */
    public function getResult(): array;
}