<?php
namespace Tasyakur\Providers\SettingsContact;

use Tasyakur\Providers\SettingsContact\Hooks\RegisterContactOption;

class SettingsContact extends \Tasyakur\Core\Contracts\ServiceProvider
{

    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->hooksLoader->addHooks(
            RegisterContactOption::class,
        );
    }
}