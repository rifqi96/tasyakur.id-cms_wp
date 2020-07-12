<?php

namespace Tasyakur\Setup\Hooks;

use Tasyakur\Core\Contracts\HooksInterface;

class ChangeEmailSendFrom implements HooksInterface
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
        add_filter('wp_mail_from_name', [$this, 'setEmailFromName']);
        add_filter('wp_mail_from', [$this, 'setEmailFrom']);
    }

    /**
     * callback from wp_mail_from_name filter
     * @param string $name
     * @return string
     */
    public function setEmailFromName( string $name ): string
    {
        return get_option('blogname') ?: $name;
    }

    /**
     * callback from wp_mail_from filter
     * @param string $email
     * @return string
     */
    public function setEmailFrom( string $email ): string
    {
        return getenv('MAIL_FROM') ?: $email;
    }
}