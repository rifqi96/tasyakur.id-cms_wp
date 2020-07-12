<?php

namespace Tasyakur\Providers\API\Hooks;

use Tasyakur\Controllers\PageController;
use Tasyakur\Controllers\PostController;
use Tasyakur\Core\Contracts\HooksInterface;

class SetupApiRoutes implements HooksInterface
{
    /**
     * @var PostController
     */
    private $postController;

    /**
     * @var PageController
     */
    private $pageController;

    public function __construct(PostController $postController, PageController $pageController)
    {
        $this->postController = $postController;
        $this->pageController = $pageController;
    }

    /**
     * Register the hook function
     *
     * @return void
     */
    public function init()
    {
        add_action('rest_api_init', [$this, 'restApiInit']);

        // Prepare Post API
        add_filter('rest_prepare_post', [$this->postController, 'restPreparePost'], 10, 3);
        // Prepare Page API
        add_filter('rest_prepare_page', [$this->pageController, 'restPreparePage'], 10, 3);
    }

    /**
     * Mix everything up
     *
     * @return void
     */
    public function restApiInit()
    {
        $this->registerRestRoutes();
        $this->registerAdditionalFields();
    }

    /**
     * Register additional rest routes
     *
     * @return void
     */
    public function registerRestRoutes()
    {
        requireAllFiles(app()::getBasePath() . '/Rest/routes/*.php');
    }

    /**
     * Register additional fields from registered endpoints
     *
     * @return void
     */
    public function registerAdditionalFields()
    {
        requireAllFiles(app()::getBasePath() . '/Rest/fields/*.php');
    }
}