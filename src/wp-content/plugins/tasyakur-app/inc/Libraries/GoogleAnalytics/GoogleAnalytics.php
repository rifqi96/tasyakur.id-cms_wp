<?php

namespace Tasyakur\Libraries\GoogleAnalytics;

use Tasyakur\Adapters\Analytics\Contracts\Analytics;
use Tasyakur\Libraries\GoogleAnalytics\Contracts\GAConfigInterface;

class GoogleAnalytics extends Analytics
{
    /**
     * @var GAConfigInterface
     */
    private $GAConfig;

    /**
     *
     * @var \Google_Service_AnalyticsReporting
     */
    private $analytics;

    /**
     * @var array|bool|false|string
     */
    private $viewId;

    /**
     * @var \Google_Service_AnalyticsReporting_ReportRequest
     */
    private $reportRequest;

    /**
     * GoogleAnalytics constructor.
     * @param GAConfigInterface $GAConfig
     * @param array $params
     */
    public function __construct(GAConfigInterface $GAConfig, array $params = [])
    {
        $this->GAConfig = $GAConfig;
        $this->viewId = GA_VIEW_ID ?? $params['view_id'] ?? false;
        $this->reportRequest = new \Google_Service_AnalyticsReporting_ReportRequest();
        $this->analytics = $this->initializeAnalytics();
    }

    /**
     * Initializes an Analytics Reporting API V4 service object.
     *
     * @return \Google_Service_AnalyticsReporting An authorized Analytics Reporting API V4 service object.
     */
    public function initializeAnalytics(): \Google_Service_AnalyticsReporting
    {
        // Create and configure a new client object.
        $client = new \Google_Client();
        $client->setApplicationName("Tasyakur Analytics Reporting");
        $client->setAuthConfig($this->GAConfig->get());
        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
        $analytics = new \Google_Service_AnalyticsReporting($client);

        return $analytics;
    }

    /**
     * Queries the Analytics Reporting API V4.
     *
     * @return \Google_Service_AnalyticsReporting_GetReportsResponse The Analytics Reporting API V4 response.
     */
    public function getReport(): \Google_Service_AnalyticsReporting_GetReportsResponse
    {
        if (!$this->reportRequest)
            throw new \InvalidArgumentException('Report request is not set');

        $body = new \Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests([$this->reportRequest]);
        return $this->analytics->reports->batchGet($body);
    }

    /**
     * @return array|bool|false|string
     */
    public function getViewId()
    {
        return $this->viewId;
    }

    /**
     * @return \Google_Service_AnalyticsReporting_ReportRequest
     */
    public function getReportRequest(): \Google_Service_AnalyticsReporting_ReportRequest
    {
        return $this->reportRequest;
    }
}