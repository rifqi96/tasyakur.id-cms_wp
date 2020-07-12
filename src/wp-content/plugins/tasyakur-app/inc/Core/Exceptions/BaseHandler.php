<?php

namespace Tasyakur\Core\Exceptions;

use Tasyakur\Adapters\MessageQueue\Contracts\QueueDriver;
use Tasyakur\Core\Contracts\HandlerInterface;
use Tasyakur\Facades\MessageQueue\Queue;
use Tasyakur\Queues\Messages\SendUncaughtExceptionEmailMessage;
use Whoops\RunInterface;

abstract class BaseHandler implements HandlerInterface
{
    /**
     * @var mixed
     */
    protected $handler;

    /**
     * @var bool
     */
    protected $isHandled;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var array Associative array
     */
    protected $data = [];

    /**
     * List of exceptions that should not be reported
     * @var array
     */
    protected $dontReport = [];

    /**
     * BaseHandler constructor.
     * @param RunInterface $handlerRunner
     */
    public function __construct(RunInterface $handlerRunner)
    {
        $this->handler = $handlerRunner;
        $this->isHandled = false;
        $this->message = '';
        $this->statusCode = 500;
        $this->data = [];
    }

    /**
     * Register the handler for production environment (Don't show the env)
     * @return void
     */
    public abstract function registerProduction();

    /**
     * Register the handler with env
     * @return void
     */
    public abstract function registerDebug();

    /**
     * Return the handler instance
     * @return mixed
     */
    public function getInstance()
    {
        return $this->handler;
    }

    /**
     * Check whether the client requests json output
     * @return bool
     */
    public function expectsJson(): bool
    {
        return isset($_SERVER['HTTP_ACCEPT']) && $_SERVER['HTTP_ACCEPT'] === 'application/json';
    }

    /**
     * Method to handle the exceptions
     *
     * @param \Throwable $exception
     * @return mixed|void
     */
    public abstract function handle(\Throwable $exception);

    public function report(\Throwable $exception): bool
    {
        // Bail early if the environment is not production
        if (ENVIRONMENT !== 'production')
            return false;

        // Bail if exception is in the $dontReport list
        if ($this->shouldntReport($exception))
            return false;

        try {
            return Queue
                ::setSerializer(QueueDriver::PHP_SERIALIZER)
                ::addMessage(
                    new SendUncaughtExceptionEmailMessage($this->statusCode, $this->message, $this->data, $exception)
                );
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * Determine if the exception should be reported.
     *
     * @param  \Throwable $e
     * @return bool
     */
    public function shouldReport(\Throwable $e): bool
    {
        return !$this->shouldntReport($e);
    }

    /**
     * Determine if the exception is in the "do not report" list.
     *
     * @param  \Throwable $e
     * @return bool
     */
    protected function shouldntReport(\Throwable $e): bool
    {
        foreach ($this->dontReport as $type) {
            if ($e instanceof $type) {
                return true;
            }
        }

        return false;
    }
}