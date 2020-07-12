<?php
namespace Tasyakur\Providers\SvgEnabler;

use Tasyakur\Core\Contracts\ServiceProvider;
use Tasyakur\Providers\SvgEnabler\Hooks\SetSvgDimensions;
use Tasyakur\Providers\SvgEnabler\Hooks\ShowSvgOnBrowser;

class SvgEnabler extends ServiceProvider
{
    /**
     * Register the service concrete class to the app
     * Hooks and filters are called here
     *
     * @return void
     */
    public function register()
    {
        $this->hooksLoader->addHooks(
            SetSvgDimensions::class,
            ShowSvgOnBrowser::class
        );
    }
}

?>