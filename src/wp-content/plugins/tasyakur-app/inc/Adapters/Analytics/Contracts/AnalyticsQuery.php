<?php
namespace Tasyakur\Adapters\Analytics\Contracts;

abstract class AnalyticsQuery implements QueryInterface
{
    /**
     * @var Analytics
     */
    protected $analytics;

    /**
     * Set the analytics for given query.
     * Concrete query class has to validate the concrete Analytics class
     * @param Analytics $analytics
     */
    public function setAnalytics(Analytics $analytics): void
    {
        $this->analytics = $analytics;
    }
}