<?php

namespace Tasyakur\Providers\API;

use Tasyakur\Core\Contracts\ServiceProvider;
use Tasyakur\Providers\API\Hooks\SetupApiRoutes;

class Setup extends ServiceProvider
{
    /**
     * {@inheritDoc}
     * @see \Tasyakur\Core\Contracts\ServiceProvider
     */
    public function register()
    {
        $this->hooksLoader->addHooks(
            SetupApiRoutes::class
        );
    }
}