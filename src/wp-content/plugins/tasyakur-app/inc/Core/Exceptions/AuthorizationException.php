<?php

namespace Tasyakur\Core\Exceptions;

use Exception;

class AuthorizationException extends Exception
{
    public function __construct()
    {
        parent::__construct('You are not authorized to perform the action', 403);
    }
}