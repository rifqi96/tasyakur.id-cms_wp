<?php
namespace Tasyakur\Setup\Hooks;

use Tasyakur\Core\Contracts\HooksInterface;

class ChangeEmailDefaultContentType implements HooksInterface
{

    /**
     * Register the hook function
     *
     * @return void
     */
    public function init()
    {
        add_filter('wp_mail_content_type', [$this, 'getHtmlContentType']);
    }

    public function getHtmlContentType( $contentType ): string
    {
        return 'text/html';
    }
}