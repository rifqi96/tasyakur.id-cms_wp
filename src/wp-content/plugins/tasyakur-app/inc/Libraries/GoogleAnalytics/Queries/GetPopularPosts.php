<?php
namespace Tasyakur\Libraries\GoogleAnalytics\Queries;

use Tasyakur\Libraries\GoogleAnalytics\GoogleAnalytics;
use Tasyakur\Libraries\GoogleAnalytics\GoogleAnalyticsQuery;
use Tasyakur\Services\PostService;

/**
 * Class GetPopularPosts
 *
 * @param $analytics GoogleAnalytics
 *
 * @package Tasyakur\Libraries\GoogleAnalytics\Query
 */
class GetPopularPosts extends GoogleAnalyticsQuery
{
    /**
     * @var PostService
     */
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Run the query
     * @return array query results
     */
    public function run(): array
    {
        // Execute queries
        $this->runQueries();

        // Get the slugs and place them in an array
        $gaSlugs = $this->output(function ($row) {
            $dimensions = $row->getDimensions();
            $metrics = $row->getMetrics();
            // $page = [];
            // $page['slug'] = \substr($dimensions[1], 1); // [0] => /stories/, [1] => /:slug; substr() also bcs the GA returns slash at the string beginning
            // $page['pageViews'] = $metrics[0]->getValues()[0]; // $metrics[0] => pageViews, $metrics[0]->getValues()[0] => :pageViews.value
            // return $page;
            return \substr($dimensions[1], 1); // [0] => /stories/, [1] => /:slug; substr() also bcs the GA returns slash at the string beginning
        });

        // Filter by slugs that are found by Google Analytics
        $posts = $this->postService->getAll([
            'posts_per_page' => -1,
            'post_type' => 'post',
            'post_name__in' => $gaSlugs,
            'orderby' => 'post_name__in',
            'fields' => ['ID']
        ]);

        return $posts;
    }

    /**
     * Run the queries for GA
     * @return void
     */
    protected function runQueries(): void
    {
        // Create the DateRange object.
        $dateRange = new \Google_Service_AnalyticsReporting_DateRange;
        $dateRange->setStartDate('2018-01-01');
        $dateRange->setEndDate('yesterday');

        // Create the Metrics object.
        $pageViews = new \Google_Service_AnalyticsReporting_Metric;
        $pageViews->setExpression('ga:pageViews');
        $pageViews->setAlias('pageViews');

        // Create the dimensions.
        // First dimension
        $pagePathL2 = new \Google_Service_AnalyticsReporting_Dimension;
        $pagePathL2->setName('ga:pagePathLevel2');
        // Second dimension
        $pagePathL3 = new \Google_Service_AnalyticsReporting_Dimension;
        $pagePathL3->setName('ga:pagePathLevel3');

        // Create the Dimension Filter.
        $dimensionFilter = new \Google_Service_AnalyticsReporting_DimensionFilter;
        $dimensionFilter->setDimensionName('ga:pagePathLevel2');
        $dimensionFilter->setOperator('PARTIAL');
        $dimensionFilter->setExpressions(['stories']);

        // Create the Dimension Filter Clauses.
        $dimensionFilterClauses = new \Google_Service_AnalyticsReporting_DimensionFilterClause;
        $dimensionFilterClauses->setFilters($dimensionFilter);

        // Create the Ordering.
        $ordering = new \Google_Service_AnalyticsReporting_OrderBy;
        $ordering->setFieldName('ga:pageviews');
        $ordering->setSortOrder('DESCENDING');

        // Apply the queries to report request
        $this->applyQuery(
            function (\Google_Service_AnalyticsReporting_ReportRequest $request) use (
                $dateRange,
                $pageViews,
                $pagePathL2,
                $pagePathL3,
                $dimensionFilter,
                $dimensionFilterClauses,
                $ordering
            ) {
                $request->setMetrics([$pageViews]);
                $request->setDateRanges($dateRange);
                $request->setDimensions([$pagePathL2, $pagePathL3]);
                $request->setDimensionFilterClauses([$dimensionFilterClauses]);
                $request->setOrderBys($ordering);
                $request->setPageSize(4);
            }
        );
    }
}