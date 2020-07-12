<?php
namespace Tasyakur\Setup\Hooks\ThemeSetups;

use Tasyakur\Core\Contracts\HooksInterface;

class HideAdminBar implements HooksInterface
{

    public function init()
    {
        show_admin_bar( false );
    }
}