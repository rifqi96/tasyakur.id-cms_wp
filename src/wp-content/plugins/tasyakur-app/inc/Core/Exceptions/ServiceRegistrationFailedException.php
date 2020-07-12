<?php

namespace Tasyakur\Core\Exceptions;

use Exception;

/**
 * Use this when service fails to register in the event of some criteria is not met.
 * This exception tends to be catched by the App at the Service Registration method, and not breaking the App.
 * Ideally, it returns a safe flash message (using session) when the request is not json and is on admin page.
 *
 * Class ServiceRegistrationFailedException
 * @package Tasyakur\Core\Exceptions
 */
class ServiceRegistrationFailedException extends Exception
{
    /**
     * ServiceRegistrationFailedException constructor.
     * @param string $className Required. The service class name.
     * @param string $errorMsg Optional.
     */
    public function __construct(string $className, string $errorMsg = 'This service failed to register')
    {
        $message = "$className: $errorMsg";

        parent::__construct($message, 500);
    }
}