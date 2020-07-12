<?php

namespace Tasyakur\Core\Exceptions;

use Exception;
use Throwable;

/**
 * Exception for theme service/plugin/hook that's not registered to the theme services list
 * Class ServiceNotFoundException
 * @package Tasyakur\Core\Exceptions
 */
class ServiceNotFoundException extends Exception
{
    /**
     * ServiceNotFoundException constructor.
     * @param string $serviceClass
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($serviceClass = '', $code = 500, Throwable $previous = null)
    {
        $message = "$serviceClass is not registered as a tasyakur-blank service class";

        parent::__construct($message, $code, $previous);
    }
}