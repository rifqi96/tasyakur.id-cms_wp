<?php
namespace Tasyakur\Adapters\MessageQueue\Contracts;

abstract class Message
{
    /**
     * @var string
     */
    protected $queueId;

    /**
     * @var MessageData
     */
    protected $data;

    public function __construct(string $queueId, string $handlerClass, array $data = [])
    {
        $this->queueId = $queueId;
        $this->data = new MessageData([
            'data' => $data,
            'handlerClass' => $handlerClass,
        ]);
    }

    /**
     * Returns full class name of the message
     * @return string
     */
    public function getName(): string
    {
        return get_class($this);
    }

    /**
     * @return string
     */
    public function getQueueId(): string
    {
        return $this->queueId;
    }

    /**
     * @return MessageData
     */
    public function getMessageData(): MessageData
    {
        return $this->data;
    }
}