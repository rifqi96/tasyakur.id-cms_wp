<?php

final class TasyakurTheme
{
    /**
     * @var array List of registered hook classes
     */
    private $hookClasses = [
        MenuHook::class,
        AddFaviconHook::class,
        TemplateChooserHook::class,
    ];

    /**
     * TasyakurTheme constructor.
     */
    public function __construct()
    {
        $this->initHooks();
    }

    /**
     * Instantiate and init hooks from $hookClasses
     *
     * @throws ErrorException
     */
    public function initHooks(): void
    {
        foreach ($this->hookClasses as $class) {
            $obj = new $class();
            // bail early
            if (! $obj instanceof HooksInterface) {
                throw new ErrorException("TasyakurTheme: $class is not an instance of " . HooksInterface::class);
            }
            // Init the hooks
            $obj->init();
        }
    }

    /**
     * @return array
     */
    public function getHookClasses(): array
    {
        return $this->hookClasses;
    }
}