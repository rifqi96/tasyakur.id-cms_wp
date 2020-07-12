<?php
namespace Tasyakur\Adapters\MessageQueue\Contracts;

interface SerializerInterface
{
    /**
     * @param array $arg
     * @return string
     */
    public function serialize( array $arg ): string;

    /**
     * @param string $serializedArg
     * @return array
     */
    public function unserialize( string $serializedArg ): array;
}