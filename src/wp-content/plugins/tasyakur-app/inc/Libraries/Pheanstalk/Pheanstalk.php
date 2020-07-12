<?php

namespace Tasyakur\Libraries\Pheanstalk;

use Tasyakur\Adapters\MessageQueue\Contracts\QueueDriver;
use Tasyakur\Adapters\MessageQueue\Contracts\Message;
use Tasyakur\Adapters\MessageQueue\Job;
use Pheanstalk\Contract\JobIdInterface;
use Pheanstalk\Pheanstalk as PheanstalkLib;
use Pheanstalk\Job as PheanstalkJob;

class Pheanstalk extends QueueDriver
{
    /**
     * @var PheanstalkLib
     */
    private $pheanstalk;

    /**
     * @var JobIdInterface
     */
    private $queuedJob;

    /**
     * Opens connection with the driver
     * @param array $args Required connection args
     * @return bool
     */
    public function connect(array $args = []): bool
    {
        try {
            $pheanstalk = PheanstalkLib::create('beanstalkd');

            if (!$pheanstalk)
                return false;

            $this->pheanstalk = $pheanstalk;
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Registers message to the queue
     * @param Message $message
     * @return QueueDriver
     */
    public function addMessage(Message $message): QueueDriver
    {
        $messageData = $message->getMessageData();
        $messageData->setSerializer($this->serializerType);

        $job = $this->pheanstalk
            ->useTube($message->getQueueId())
            ->put($this->serialize(
                $messageData
            ));

        if (!$job)
            return $this;

        $this->queuedJob = $job;

        return $this;
    }

    /**
     * @param array $queueIds
     * @return Job|null
     */
    public function watch(array $queueIds): ?Job
    {
        $pheanstalkJob = $this->pheanstalk;
        foreach ($queueIds as $queueId) {
            $pheanstalkJob = $pheanstalkJob
                ->watch($queueId);
        }

        try {
            /* @var $pheanstalkJob \Pheanstalk\Job */
            $pheanstalkJob = $pheanstalkJob->ignore('default')->reserve();
        } catch (\Exception $e) {
            return null;
        }

        if (!$pheanstalkJob)
            return null;

        $job = app()->make(Job::class, [
            'driver' => $this,
            'id' => $pheanstalkJob->getId(),
            'data' => $pheanstalkJob->getData(),
        ]);
        $this->watchedJob = $job;
        return $job;
    }

    /**
     * Returns a list of queues
     * @return string[]
     */
    public function listQueues(): array
    {
        return $this->pheanstalk->listTubes();
    }

    /**
     * Deletes current message on the queue.
     * @param $job Job
     * @return bool
     */
    public function delete(Job $job): bool
    {
        try {
            $pheanstalkJob = new PheanstalkJob($job->getId(), $job->getData());
            $this->pheanstalk->delete($pheanstalkJob);
            $this->watchedJob = null;
            return true;
        } catch (\Exception $e) {
            error_log("Error on deleting pheanstalk job: {$e->getMessage()} - on file {$e->getFile()} at line {$e->getLine()} - Trace: \n {$e->getTrace()}");
            return false;
        }
    }

    /**
     * Buries current message on the queue.
     * @param $job Job
     * @return bool
     */
    public function bury(Job $job): bool
    {
        try {
            $pheanstalkJob = new PheanstalkJob($job->getId(), $job->getData());
            $this->pheanstalk->bury($pheanstalkJob);
            $this->watchedJob = null;
            return true;
        } catch (\Exception $e) {
            error_log("Error on deleting pheanstalk job: {$e->getMessage()} - on file {$e->getFile()} at line {$e->getLine()} - Trace: \n {$e->getTrace()}");
            return false;
        }
    }

    /**
     * Checks whether job exists on the pool
     * @param $job Job
     * @return bool
     */
    public function jobExists(Job $job): bool
    {
        $pheanstalkJob = new PheanstalkJob($job->getId(), $job->getData());
        return isset($pheanstalkJob);
    }
}