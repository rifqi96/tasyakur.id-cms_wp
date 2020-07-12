<?php

namespace Tasyakur\Adapters\MessageQueue;

use Tasyakur\Adapters\MessageQueue\Contracts\QueueDriver;
use Tasyakur\Adapters\MessageQueue\Contracts\SerializerInterface;
use Tasyakur\Adapters\MessageQueue\SerializerStrategy\JsonSerializer;
use Tasyakur\Adapters\MessageQueue\SerializerStrategy\PhpSerializer;

class SerializerFactory
{
    /**
     * Returns serializer
     * @param string $type
     * @return SerializerInterface
     */
    public static function build ( string $type = '' ): SerializerInterface
    {
        $serializer = null;
        if ($type === QueueDriver::JSON_SERIALIZER) {
            $serializer = app()->get(JsonSerializer::class);
        }
        else if ($type === QueueDriver::PHP_SERIALIZER) {
            $serializer = app()->get(PhpSerializer::class);
        }
        else {
            throw new \InvalidArgumentException('Wrong serializer type');
        }

        return $serializer;
    }
}