<?php
namespace Tasyakur\Core\Exceptions;

use Exception;

/**
 * Use this when a validation or arguments don't meet the requirement
 * Class ValidationException
 * @package Tasyakur\Core\Exceptions
 */
class ValidationException extends Exception
{
    /**
     * @var array List of errors
     */
    private $errors = [];

    /**
     * ValidationException constructor.
     * @param array $errors
     */
    public function __construct(array $errors = [])
    {
        $this->errors = $errors;

        parent::__construct('Validation error.', 400);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @param array $error
     * @return ValidationException
     */
    public function addError(array $error): ValidationException
    {
        array_push($this->errors, $error);
        return $this;
    }
}