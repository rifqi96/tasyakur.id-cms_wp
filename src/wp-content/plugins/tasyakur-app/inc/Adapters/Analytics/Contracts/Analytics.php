<?php
namespace Tasyakur\Adapters\Analytics\Contracts;

abstract class Analytics implements AnalyticsInterface
{
    /**
     * @var AnalyticsQuery
     */
    protected $query;

    /**
     * @var array
     */
    protected $result;

    public function runQuery(AnalyticsQuery $query): AnalyticsInterface
    {
        $query->setAnalytics($this);
        $this->query = $query;
        $this->result = $query->run();
        return $this;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }
}