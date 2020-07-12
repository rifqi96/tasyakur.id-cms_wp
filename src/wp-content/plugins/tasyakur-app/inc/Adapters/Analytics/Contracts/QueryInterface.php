<?php
namespace Tasyakur\Adapters\Analytics\Contracts;

interface QueryInterface
{
    /**
     * Run the query
     * @return array query results
     */
    public function run(): array;
}