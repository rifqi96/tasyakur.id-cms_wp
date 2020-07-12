<?php

namespace Tasyakur\Core\Exceptions;

use Exception;

/**
 * Exception for accessing a page that doesn't exist
 * Class PageNotFoundException
 * @package Tasyakur\Core\Exceptions
 */
class PageNotFoundException extends Exception
{
    /**
     * Http status code
     * @var int
     */
    private $statusCode;

    public function __construct()
    {
        $message = 'Page is not found';
        $statusCode = 404;

        $this->statusCode = $statusCode;

        parent::__construct($message, $statusCode);
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
    }
}