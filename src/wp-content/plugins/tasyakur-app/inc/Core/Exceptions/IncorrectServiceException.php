<?php

namespace Tasyakur\Core\Exceptions;

use Exception;
use Throwable;

class IncorrectServiceException extends Exception
{
    /**
     * IncorrectServiceException constructor.
     * @param string $serviceClass
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($serviceClass = '', $code = 500, Throwable $previous = null)
    {
        $message = "$serviceClass is not a tasyakur-blank service class";

        parent::__construct($message, $code, $previous);
    }
}