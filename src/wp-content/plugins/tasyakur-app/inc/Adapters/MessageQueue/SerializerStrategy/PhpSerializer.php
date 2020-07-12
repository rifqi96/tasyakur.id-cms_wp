<?php

namespace Tasyakur\Adapters\MessageQueue\SerializerStrategy;

use Tasyakur\Adapters\MessageQueue\Contracts\SerializerInterface;

class PhpSerializer implements SerializerInterface
{

    /**
     * @param $arg
     * @return string
     */
    public function serialize($arg): string
    {
        return serialize($arg);
    }

    /**
     * @param string $serializedArg
     * @return array
     */
    public function unserialize(string $serializedArg): array
    {
        return unserialize($serializedArg);
    }
}