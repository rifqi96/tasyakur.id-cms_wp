<?php
namespace Tasyakur\Providers\ACF\Contracts;

interface FieldInterface
{
    /**
     * Return an array of ACF field settings
     * @return array
     */
    public function getField(): array;
}