<?php
namespace Tasyakur\Adapters\MessageQueue\SerializerStrategy;

use Tasyakur\Adapters\MessageQueue\Contracts\SerializerInterface;

class JsonSerializer implements SerializerInterface
{

    /**
     * @param array $arg
     * @return string
     */
    public function serialize(array $arg): string
    {
        return \json_encode($arg, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param string $serializedArg
     * @return array
     */
    public function unserialize(string $serializedArg): array
    {
        return \json_decode($serializedArg, true);
    }
}