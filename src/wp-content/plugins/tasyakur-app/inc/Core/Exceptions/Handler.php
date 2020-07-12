<?php

namespace Tasyakur\Core\Exceptions;

use Tasyakur\Core\Contracts\HandlerInterface;
use Tasyakur\Core\Contracts\ServiceProvider;
use Tasyakur\Core\HooksLoader;

class Handler extends ServiceProvider
{
    private $handler;

    public function __construct(HandlerInterface $handler)
    {
        $this->handler = $handler;
        parent::__construct(app()->get(HooksLoader::class));
    }

    /**
     * Register the service concrete class to the app
     * Hooks and filters are called here
     *
     * @return void
     */
    public function register()
    {
        if (WP_DEBUG && (ENVIRONMENT === 'production' || ENVIRONMENT !== 'staging')) {
            $this->handler->registerDebug();
        } else {
            $this->handler->registerProduction();
        }

        // Register the handler
        $this->handler->getInstance()
            ->register();
    }
}