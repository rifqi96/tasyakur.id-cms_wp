<?php
namespace Tasyakur\Setup\Hooks\ThemeSetups;

class ChangeArchiveTitle implements \Tasyakur\Core\Contracts\HooksInterface
{

    /**
     * @inheritDoc
     */
    public function init()
    {
        add_filter('the_title', [$this, 'changeTitle']);
    }

    public function changeTitle()
    {

    }
}