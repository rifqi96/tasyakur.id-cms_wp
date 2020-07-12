<?php

namespace Tasyakur\Providers\ACF;

use Tasyakur\Core\Contracts\ServiceProvider;
use Tasyakur\Core\Exceptions\ServiceRegistrationFailedException;

class Setup extends ServiceProvider
{
    /**
     * {@inheritDoc}
     * @see \Tasyakur\Core\Contracts\ServiceProvider
     */
    public function register()
    {
        // Called after user is authenticated
        add_action('init', [$this, 'init']);
    }

    /**
     * @throws ServiceRegistrationFailedException
     */
    public function init()
    {
        if (!is_plugin_active('advanced-custom-fields-pro/acf.php') || !function_exists('acf_add_local_field_group'))
            throw new ServiceRegistrationFailedException(self::class, 'ACF plugin is not active, please activate it in order to register this service.');

        $this->hooksLoader->addHooks(
        // Register ACF Groups
        );
    }
}