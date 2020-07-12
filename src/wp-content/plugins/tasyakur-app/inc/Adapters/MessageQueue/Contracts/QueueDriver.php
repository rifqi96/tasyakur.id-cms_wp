<?php
namespace Tasyakur\Adapters\MessageQueue\Contracts;

use Tasyakur\Adapters\MessageQueue\Job;
use Tasyakur\Adapters\MessageQueue\SerializerFactory;

abstract class QueueDriver
{
    /**
     * Must follow one of the _SERIALIZER constant options.
     * @var string
     */
    protected $serializerType;

    /**
     *
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var Job
     */
    protected $watchedJob;

    /**
     * Use this to serialize with json_encode() and unserialize with json_decode().
     * @var string
     */
    public const JSON_SERIALIZER = 'json';

    /**
     * Use this to serialize with serialize() and unserialize with unserialize() built-in php function.
     * @var string
     */
    public const PHP_SERIALIZER = 'php_serializer';

    public function __construct( string $serializerType = '' )
    {
        $this->setSerializer($serializerType);
        $this->connect();
    }

    /**
     * Opens connection with the driver
     * @param array $args Required connection args
     * @return bool
     */
    public abstract function connect(array $args = []): bool;

    /**
     * Registers message to the queue
     * @param Message $message
     * @return self
     */
    public abstract function addMessage(Message $message): self;

    /**
     * Watches the queue(s) and returns the job from given queue
     * @param array $queueIds
     * @return Job|null
     */
    public abstract function watch(array $queueIds): ?Job;

    /**
     * Deletes current message on the queue.
     * @param $job Job
     * @return bool
     */
    public abstract function delete(Job $job): bool;

    /**
     * Buries current message on the queue.
     * @param $job Job
     * @return bool
     */
    public abstract function bury(Job $job): bool;

    /**
     * Checks whether job exists on the pool
     * @param $job Job
     * @return bool
     */
    public abstract function jobExists(Job $job): bool;

    /**
     * Returns a list of queues
     * @return string[]
     */
    public abstract function listQueues(): array;

    /**
     * @param string $serializerType
     */
    public final function setSerializer( string $serializerType ): void
    {
        // Exit if current serializer is the same
        if ($serializerType === $this->serializerType)
            return;

        $this->serializer = SerializerFactory::build($serializerType);
        $this->serializerType = $serializerType;
    }

    /**
     * @param MessageData $messageData
     * @return string
     * @throws \Exception
     */
    public final function serialize( MessageData $messageData ): string
    {
        // Serialize the message data
        $data = $messageData->getData();
        $serializedData = $this->serializer->serialize($data);
        $mainData = $messageData->output();
        $mainData['data'] = $serializedData;

        // Serialize and return the main data with json_encode
        $encoded = \json_encode($mainData, JSON_UNESCAPED_UNICODE);

        if (!$encoded)
            return '';

        return $encoded;
    }

    /**
     * @param string $arg
     * @return MessageData
     * @throws \Exception
     */
    public final function unserialize( string $arg ): MessageData
    {
        // Unserialize the main data with json_decode
        $mainData = \json_decode($arg, true);

        // Bail early
        if (!isset($mainData['data']))
            throw new \InvalidArgumentException('Invalid data format to unserialize');

        // Unserialize the message data
        if (isset($mainData['serializer'])) {
            $serializerType = $mainData['serializer'];
            $this->setSerializer($serializerType);
        }
        $mainData['data'] = $this->serializer->unserialize($mainData['data']);

        // Return and the main data
        return new MessageData($mainData);
    }
}