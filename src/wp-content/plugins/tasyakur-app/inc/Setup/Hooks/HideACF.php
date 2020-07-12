<?php

namespace Tasyakur\Setup\Hooks;

use Tasyakur\Core\Contracts\HooksInterface;

class HideACF implements HooksInterface
{
    public function __construct()
    {
        //
    }

    /**
     * {@inheritDoc}
     * @see HooksInterface::init()
     */
    public function init()
    {
        add_filter('acf/settings/show_admin', '__return_false');
    }
}