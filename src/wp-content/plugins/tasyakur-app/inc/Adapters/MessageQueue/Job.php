<?php

namespace Tasyakur\Adapters\MessageQueue;

use Tasyakur\Adapters\MessageQueue\Contracts\QueueDriver;

class Job
{
    /**
     * @var string
     */
    private $data;

    /**
     * @var int
     */
    private $id;

    /**
     * @var QueueDriver
     */
    private $driver;

    public function __construct(QueueDriver $driver, int $id, string $data)
    {
        $this->driver = $driver;
        $this->data = $data;
        $this->id = $id;
    }

    /**
     * Returns serialized data from given message on the queue
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * Returns the job id
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return QueueDriver
     */
    public function getDriver(): QueueDriver
    {
        return $this->driver;
    }
}