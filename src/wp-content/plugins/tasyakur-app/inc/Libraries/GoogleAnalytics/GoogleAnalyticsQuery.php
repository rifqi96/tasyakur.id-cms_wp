<?php
namespace Tasyakur\Libraries\GoogleAnalytics;

use Tasyakur\Adapters\Analytics\Contracts\Analytics;
use Tasyakur\Adapters\Analytics\Contracts\AnalyticsQuery;

abstract class GoogleAnalyticsQuery extends AnalyticsQuery
{
    /**
     * @var GoogleAnalytics
     */
    protected $analytics;

    public function setAnalytics(Analytics $analytics): void
    {
        // Check if analytics property is google analytics
        if (!$analytics instanceof GoogleAnalytics)
            throw new \InvalidArgumentException("Instance of analytics expected " . GoogleAnalytics::class . " , but it is " . get_class($analytics) . " instead");

        parent::setAnalytics($analytics);
    }

    /**
     * Apply queries in the given callback
     *
     * @param callable|null $callback an anonymous func to add queries to $reportRequest on the fly
     * @return GoogleAnalyticsQuery
     */
    public function applyQuery(callable $callback = null): GoogleAnalyticsQuery
    {
        $this->analytics->getReportRequest()->setViewId(
            $this->analytics->getViewId()
        );

        if (is_callable($callback)) {
            call_user_func($callback, $this->analytics->getReportRequest());
        }

        return $this;
    }

    /**
     * Parses and prints the Analytics Reporting API V4 response.
     *
     * @param callable|null $callback defines what to show on each results row
     * @return array
     */
    public function output(callable $callback = null): array
    {
        $reports = $this->analytics->getReport();
        if (!$reports instanceof \Google_Service_AnalyticsReporting_GetReportsResponse)
            throw new \InvalidArgumentException('Error on Printing Reports: Reports response is not valid');

        $res = [];
        for ($reportIndex = 0; $reportIndex < count($reports); $reportIndex++) {
            $report = $reports[$reportIndex];
            $reportRows = $report->getData()->getRows();

            for ($rowIndex = 0; $rowIndex < count($reportRows); $rowIndex++) {
                $reportRow = $reportRows[$rowIndex];
                $resRow = null;
                if (is_callable($callback))
                    $resRow = call_user_func($callback, $reportRow);

                array_push($res, $resRow);
            }
        }

        return $res;
    }

    /**
     * Run the queries for GA
     * @return void
     */
    protected abstract function runQueries();
}