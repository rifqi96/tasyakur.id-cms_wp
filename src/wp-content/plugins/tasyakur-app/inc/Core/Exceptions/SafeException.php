<?php

namespace Tasyakur\Core\Exceptions;

use Exception;

/**
 * Use this exception if you need to do use a custom message exception and don't want to report. Make sure to catch this exception without breaking the app.
 * Class SafeException
 * @package Tasyakur\Core\Exceptions
 */
class SafeException extends Exception
{
    public function __construct(string $message = '', int $statusCode = 500)
    {
        parent::__construct($message, $statusCode);
    }
}