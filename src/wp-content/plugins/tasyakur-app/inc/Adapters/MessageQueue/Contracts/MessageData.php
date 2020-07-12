<?php

namespace Tasyakur\Adapters\MessageQueue\Contracts;

class MessageData
{
    /**
     * It's encouraged to use an associative array
     * @var array|mixed
     */
    private $data;

    /**
     * @var string
     */
    private $handlerClass;

    /**
     * @var string
     */
    private $serializer;

    /**
     * MessageData constructor.
     * @param array $data an associative array of the message data
     */
    public function __construct(array $data)
    {
        if (!isset($data['data']))
            throw new \InvalidArgumentException('MessageData: data must be provided');

        if (!isset($data['handlerClass']))
            throw new \InvalidArgumentException('MessageData: Handler class must be provided');

        $this->data = $data['data'];
        $this->handlerClass = $data['handlerClass'];
        if (isset($data['serializer']))
            $this->serializer = $data['serializer'];
    }

    /**
     * @return array|mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array|mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getHandlerClass(): string
    {
        return $this->handlerClass;
    }

    /**
     * @param string $handlerClass
     */
    public function setHandlerClass(string $handlerClass)
    {
        $this->handlerClass = $handlerClass;
    }

    /**
     * @return string
     */
    public function getSerializer(): string
    {
        return $this->serializer;
    }

    /**
     * @param string $serializer
     */
    public function setSerializer(string $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Returns the message data in an associative array
     * @return array
     */
    public function output(): array
    {
        return [
            'data' => $this->data,
            'handlerClass' => $this->handlerClass,
            'serializer' => $this->serializer,
        ];
    }
}