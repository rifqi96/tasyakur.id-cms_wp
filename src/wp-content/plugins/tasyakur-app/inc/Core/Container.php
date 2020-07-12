<?php

namespace Tasyakur\Core;

use DI\ContainerBuilder;
use DI\FactoryInterface;
use Tasyakur\Core\Contracts\ContainerInterface as ContainerContract;

class Container implements ContainerContract
{
    /**
     * The base path of the application installation.
     *
     * @var string
     */
    protected static $basePath;

    /**
     * Hold the instance of the class
     *
     * @var Container|self|null
     */
    protected static $instance = null;

    /**
     * Returns container object
     * Currently using \DI\Container (ContainerContract)
     *
     * @var mixed|ContainerContract|\DI\Container
     */
    protected static $container;

    /**
     * Init the container
     *
     * @param ContainerBuilder $containerBuilder
     * @param string|null $basePath
     */
    protected function __construct(ContainerBuilder $containerBuilder, string $basePath = null)
    {
        static::$basePath = $basePath;

        if (ENVIRONMENT === 'production' || ENVIRONMENT === 'staging') {
            $containerBuilder->enableCompilation(static::$basePath . '/caches');
            $containerBuilder->writeProxiesToFile(true, static::$basePath . '/caches/proxies');
        }

        // Add list of predefined class definitions
        $definitionFiles = glob(
            static::$basePath . '/config/*.php'
        );
        foreach ($definitionFiles as $definitionFile) {
            $containerBuilder->addDefinitions($definitionFile);
        }

        static::$container = $containerBuilder->build();
    }

    /**
     * Call this method to get the singleton
     *
     * @return static|self
     */
    public static function getInstance(): self
    {
        if (!static::$instance) {
            static::$instance = static::get(static::class);
        }

        return static::$instance;
    }

    /**
     * Set the shared instance of the container.
     *
     * @param  \Tasyakur\Core\Contracts\ContainerInterface|null $container
     */
    public static function setInstance(ContainerContract $container = null)
    {
        static::$instance = $container;
    }

    /**
     * Get the app container
     *
     * @return mixed|ContainerContract|\DI\Container
     */
    public static function getContainer()
    {
        return static::$container;
    }

    /**
     * Get the app base path
     *
     * @return string
     */
    public static function getBasePath(): string
    {
        return static::$basePath;
    }

    /**
     * {@inheritDoc}
     * @see ContainerContract::get()
     * @return mixed
     */
    public function get($id)
    {
        return static::$container->get($id);
    }

    /**
     * {@inheritDoc}
     * @see ContainerContract::has()
     */
    public function has($id)
    {
        return static::$container->has($id);
    }

    /**
     * {@inheritdoc}
     * @see FactoryInterface::make()
     */
    public function make($id, array $params = [])
    {
        return static::$container->make($id, $params);
    }
}