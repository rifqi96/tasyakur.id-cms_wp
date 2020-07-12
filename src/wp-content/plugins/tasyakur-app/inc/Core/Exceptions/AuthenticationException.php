<?php

namespace Tasyakur\Core\Exceptions;

use Exception;

class AuthenticationException extends Exception
{
    public function __construct()
    {
        parent::__construct('You are not authenticated', 401);
    }
}