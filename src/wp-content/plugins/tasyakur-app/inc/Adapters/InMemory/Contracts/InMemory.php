<?php
namespace Tasyakur\Adapters\InMemory\Contracts;

interface InMemory
{
    /**
     * @param string $key
     * @return null|string
     */
    public function get(string $key): ?string;

    /**
     * @param string $key
     * @param string $value
     * @param int|null $ttl in second. leave it null to keep the key alive
     * @param bool $forceOverwrite true will overwrite existing key, else it fails to set
     * @return bool returns true if success
     */
    public function set(string $key, string $value, ?int $ttl = null, bool $forceOverwrite = true): bool;

    /**
     * Deletes one or multiple items
     * @param \int[] ...$keys
     * @return bool|int true/false if only 1 key given. returns number of deleted keys if multiple keys given.
     */
    public function del(int ...$keys);

    /**
     * Renames a key
     * @param string $key
     * @param string $newKey
     * @return mixed
     */
    public function rename(string $key, string $newKey): bool;

    /**
     * Adds an TTL (Time To Live) in second to a key
     * @param string $key
     * @param int $ttl
     * @return bool
     */
    public function expire(string $key, int $ttl): bool;
}