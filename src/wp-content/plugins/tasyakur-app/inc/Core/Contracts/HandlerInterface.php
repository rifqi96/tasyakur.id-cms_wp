<?php

namespace Tasyakur\Core\Contracts;

interface HandlerInterface
{
    /**
     * Register the handler for production environment (Don't show the env)
     * @return void
     */
    public function registerProduction();

    /**
     * Register the handler with env
     * @return void
     */
    public function registerDebug();

    /**
     * Return the handler instance
     * @return mixed
     */
    public function getInstance();

    /**
     * Check whether the client requests json output
     * @return bool
     */
    public function expectsJson(): bool;

    /**
     * Report exceptions (Email or Logging)
     *
     * @param \Throwable $exception
     * @return bool
     */
    public function report(\Throwable $exception): bool;

    /**
     * Determine if the exception should be reported.
     *
     * @param  \Throwable $e
     * @return bool
     */
    public function shouldReport(\Throwable $e): bool;
}