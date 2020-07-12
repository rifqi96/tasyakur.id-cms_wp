<?php
namespace Tasyakur\Core\Exceptions;

/**
 * Exception for resource that doesn't exist. It may come from a model, database and any other resources.
 * Class ResourceNotFoundException
 * @package Tasyakur\Core\Exceptions
 */
class ResourceNotFoundException extends \Exception
{
    /**
     * Http status code
     * @var int
     */
    private $statusCode;

    public function __construct(string $message = 'Resource is not found')
    {
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