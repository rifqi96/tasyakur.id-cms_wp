<?php
namespace Tasyakur\Facades\MessageQueue;

use Tasyakur\Adapters\MessageQueue\Job as QueueJob;

class Job
{
    /**
     * @var QueueJob
     */
    private $job;

    public function __construct(QueueJob $job)
    {
        $this->job = $job;
    }

    /**
     * Sets the job for this facade. Typically coming from QueueFacade::watch()
     * @param QueueJob $job
     * @return void
     */
    public function setJob(QueueJob $job)
    {
        $this->job = $job;
    }

    /**
     * Returns an array of:
     * [
     *  'data' => mixed,
     *  'handlerClass' => string,
     *  'serializer' => string,
     * ]
     * @param $onlyGetData bool Set true to get $driver->getData()['data']. Default false.
     * @return array|mixed It could be mixed type if $onlyGetData is true, because the message data is not necessarily an array.
     */
    public function getData(bool $onlyGetData = true)
    {
        $data = $this->job->getData();
        $data = $this->job->getDriver()
            ->unserialize($data)
            ->output();

        if ($onlyGetData)
            $data = $data['data'] ?? null;

        return $data;
    }

    /**
     * @return int
     */
    public function getJobId(): int
    {
        return $this->job->getId();
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $res = $this->job->getDriver()->delete($this->job);

        if (!$res)
            return false;

        $this->job = null;
        return true;
    }

    /**
     * @return bool
     */
    public function bury(): bool
    {
        $res = $this->job->getDriver()->bury($this->job);

        if (!$res)
            return false;

        $this->job = null;
        return true;
    }

    /**
     * @return bool
     */
    public function jobExists(): bool
    {
        return $this->job->getDriver()->jobExists($this->job);
    }
}