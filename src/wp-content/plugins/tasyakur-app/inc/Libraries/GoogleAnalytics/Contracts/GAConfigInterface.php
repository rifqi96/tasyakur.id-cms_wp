<?php
namespace Tasyakur\Libraries\GoogleAnalytics\Contracts;

/**
 * The derived class that implements this interface MUST return a ga config as an array
 */
interface GAConfigInterface
{
    /**
     * Returns an array of GA config
     * @return array
     */
    public function get(): array;
}