<?php
namespace Tasyakur\Core\Contracts;

use Tasyakur\Core\HooksLoader;

/**
 * Class ServiceProvider
 *
 * Main app service abstract class. Concrete class must implement register().
 *
 * @package Tasyakur\Core\Contracts
 */
abstract class ServiceProvider
{
    /**
     * @var HooksLoader
     */
    protected $hooksLoader;

    /**
     * ServiceProvider constructor.
     * @param HooksLoader $hooksLoader
     */
    public function __construct(HooksLoader $hooksLoader)
    {
        $this->hooksLoader = $hooksLoader;
    }

    /**
     * Register the service concrete class to the app
     * Hooks and filters are called here
     *
     * @return void
     */
    abstract public function register();
}