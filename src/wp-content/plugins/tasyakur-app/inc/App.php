<?php
namespace Tasyakur;

use DI\ContainerBuilder;
use Tasyakur\Core\Container;
use Tasyakur\Core\Contracts\ServiceProvider;
use Tasyakur\Core\Exceptions\Handler;
use Tasyakur\Core\Exceptions\IncorrectServiceException;
use Tasyakur\Core\Exceptions\ServiceNotFoundException;
use Tasyakur\Core\Exceptions\ServiceRegistrationFailedException;

/**
 * This theme uses PSR-4 and OOP logic instead of procedural coding
 * Every function, hook and action is properly divided and organized inside related folders and files
 *
 * This is the main class of the App. All services and classes are bootstrapped here.
 * Since this is the main class, avoiding massive inheritance is important, and thus this is a final class.
 *
 * @package tasyakur-app
 */
final class App extends Container
{
    /**
     * List of service classes
     *
     * @var array
     */
    protected $classes = [];

    /**
     * List of active services
     *
     * @var array
     */
    protected $services = [];

    /**
     * Create a new Tasyakur application instance.
     *
     * @param string|null $basePath
     * @param bool $bootstrapServices
     */
    public function __construct(string $basePath = null, $bootstrapServices = true)
    {
        parent::__construct(
            new ContainerBuilder(),
            $basePath
        );

        $this->bootstrapContainer();

        if ($bootstrapServices) {
            $this->registerClasses();

            $this->registerServices();
        }
    }

    /**
     * Bootstrap the application container.
     *
     * @return void
     */
    protected function bootstrapContainer()
    {
        static::setInstance($this);
    }

    /**
     * Get all the classes inside an array
     *
     * @return array Full list of classes
     */
    public function getClasses(): array
    {
        return $this->classes;
    }

    /**
     * Get a full list of instantiated services
     *
     * @return array
     */
    public function getServices(): array
    {
        return $this->services;
    }

    /**
     * Get the service from given class
     *
     * @param string $class
     * @return ServiceProvider
     * @throws ServiceNotFoundException
     */
    public function getService(string $class): ServiceProvider
    {
        if (!array_key_exists($class, $this->services))
            throw new ServiceNotFoundException($class);

        return $this->services[$class];
    }

    /**
     * Loop through the classes, initialize them, and call the register() method if it exists
     * @return void
     */
    protected function registerServices()
    {
        foreach ($this->getClasses() as $class) {
            try {
                $this->register($class);
            } // Catch service registration failed exception
            catch (ServiceRegistrationFailedException $e) {
                // Flash message to admin page
                flashAdminNotice($e->getMessage(), $e->getCode());
                // Skip the service to register
                continue;
            }
        }
    }

    /**
     * Register a single service
     *
     * @param string $class
     * @return self
     * @throws IncorrectServiceException
     */
    public function register(string $class): self
    {
        // Instantiate / resolve the class to object
        $service = $this->get($class);

        // Skip register non service class
        if (!$service instanceof ServiceProvider)
            throw new IncorrectServiceException($class);

        // Skip if the class is already registered
        if (in_array($class, $this->services))
            return $this;

        // Run the service register() method to init up the service
        $service->register();
        // Save the service to the main app class
        $this->services[$class] = $service;

        return $this;
    }

    /**
     * Store all the service classes here
     * @return void
     */
    protected function registerClasses()
    {
        $this->classes = [
            // Handler and Setup have to be registered at the beginning
            Handler::class,
            Setup\Setup::class,

            Providers\ACF\Setup::class,
            Providers\PostTypeProducts\PostTypeProducts::class,
            Providers\PostTypeTestimonials\PostTypeTestimonials::class,
            Providers\SvgEnabler\SvgEnabler::class,
        ];
    }
}