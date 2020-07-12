<?php
namespace Tasyakur\Adapters\MessageQueue\Contracts;

use Tasyakur\Facades\MessageQueue\Job;

abstract class Handler
{
    /**
     * @var Job
     */
    protected $job;

    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    /**
     * @return Job
     */
    public function getJob(): Job
    {
        return $this->job;
    }

    /**
     * Main handler method
     * @return void
     */
    public abstract function handle(): void;
}