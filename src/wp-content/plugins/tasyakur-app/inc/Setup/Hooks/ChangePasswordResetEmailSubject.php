<?php

namespace Tasyakur\Setup\Hooks;

use Tasyakur\Core\Contracts\HooksInterface;

class ChangePasswordResetEmailSubject implements HooksInterface
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
        add_filter('retrieve_password_title', [$this, 'setEmailSubject']);
    }

    public function setEmailSubject()
    {
        return 'Password Reset';
    }
}