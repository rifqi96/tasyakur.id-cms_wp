<?php
namespace Tasyakur\Facades\MessageQueue;

use Tasyakur\Adapters\MessageQueue\Contracts\QueueDriver;
use Tasyakur\Adapters\MessageQueue\Contracts\Message;
use Tasyakur\Adapters\MessageQueue\Job;

class Queue
{
    /**
     * @var QueueDriver
     */
    private $driver;

    /**
     * Hold the instance of the class
     *
     * @var self|null
     */
    protected static $instance = null;

    public function __construct(QueueDriver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Call this method to get the singleton
     *
     * @return static|self
     */
    public static function getInstance(): self
    {
        if (!static::$instance) {
            static::$instance = app()->get(static::class);
        }

        return static::$instance;
    }

    /**
     * Adds the message to the queue driver
     * @param Message $message
     * @return bool
     */
    public static function addMessage(Message $message): bool
    {
        try {
            $queue = static::getInstance();

            $queue->driver
                ->addMessage($message);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Returns a list of queues
     * @return string[]
     */
    public static function listQueues(): array
    {
        $queue = static::getInstance();

        return $queue->driver->listQueues();
    }

    /**
     * @param array|null $queueIds
     * @return Job|null
     */
    public static function watch(?array $queueIds = []): ?Job
    {
        $queue = static::getInstance();

        return $queue->driver->watch($queueIds);
    }

    /**
     * Must follow QueueDriver's serializer constant options
     * @param string $serializer
     * @return Queue
     */
    public static function setSerializer(string $serializer): self
    {
        $queue = static::getInstance();

        $queue->driver->setSerializer($serializer);

        return static::$instance = $queue;
    }
}