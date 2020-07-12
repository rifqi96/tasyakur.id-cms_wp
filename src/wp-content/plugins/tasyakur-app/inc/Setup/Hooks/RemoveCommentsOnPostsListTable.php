<?php
namespace Tasyakur\Setup\Hooks;

use Tasyakur\Core\Contracts\HooksInterface;

class RemoveCommentsOnPostsListTable implements HooksInterface
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
        add_filter('manage_posts_columns', function ($columns) {
            unset($columns['comments']);
            return $columns;
        });
    }
}