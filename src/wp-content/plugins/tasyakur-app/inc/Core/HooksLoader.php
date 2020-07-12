<?php

namespace Tasyakur\Core;

use Tasyakur\Core\Contracts\HooksInterface;

/**
 * Class HooksLoader
 *
 * Loads and saves HooksInterface class
 *
 * @package Tasyakur\Core
 */
class HooksLoader
{
    /**
     * Hooks List
     *
     * @var array
     */
    private $hooks = [];

    /**
     * {@inheritDoc}
     * @see \Tasyakur\Core\HooksLoader::getHooks()
     */
    public function getHooks(): array
    {
        return $this->hooks;
    }

    /**
     * {@inheritDoc}
     * @see \Tasyakur\Core\HooksLoader::getHook()
     */
    public function getHook(string $hookClass): HooksInterface
    {
        return $this->hooks[$hookClass];
    }

    /**
     * {@inheritDoc}
     * @see \Tasyakur\Core\HooksLoader::addHooks()
     */
    public function addHooks(...$hookClasses): self
    {
        if (!is_array($hookClasses) && func_num_args() > 0)
            $hookClasses = func_get_args();

        // Bail early
        if (count($hookClasses) < 1)
            return $this;

        foreach ($hookClasses as $hookClass) {
            $hook = $this->instantiate($hookClass);

            if ($hook instanceof HooksInterface) {
                $hook->init();
                $this->hooks[$hookClass] = $hook;
            }
        }

        return $this;
    }

    /**
     * Instantiate hook class name
     *
     * @param string $hookClass
     * @return HooksInterface
     */
    protected function instantiate(string $hookClass): HooksInterface
    {
        return app()->get($hookClass);
    }
}