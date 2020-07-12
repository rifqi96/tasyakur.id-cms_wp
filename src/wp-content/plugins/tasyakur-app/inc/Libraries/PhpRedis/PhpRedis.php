<?php
namespace Tasyakur\Libraries\PhpRedis;

use Tasyakur\Adapters\InMemory\Contracts\InMemory;

class PhpRedis implements InMemory
{
    /**
     * @var \Redis
     */
    private $redis;

    public function __construct()
    {
        $redisHost = getenv('REDIS_HOST') ?? '127.0.0.1';
        $redisPort = getenv('REDIS_PORT') ?? 6379;
        $redisPassword = getenv('REDIS_PASSWORD') ?? null;

        $this->redis = new \Redis();
        $this->redis->pconnect($redisHost, $redisPort);
        $this->redis->auth($redisPassword);
    }

    /**
     * @param string $key
     * @return null|string
     */
    public function get(string $key): ?string
    {
        $res = $this->redis->get($key);

        if (!$res)
            return null;

        return $res;
    }

    /**
     * @param string $key
     * @param string $value
     * @param int|null $ttl in second. leave it null to keep the key alive
     * @param bool $forceOverwrite true will overwrite existing key, else it fails to set
     * @return bool returns true if success
     */
    public function set(string $key, string $value, ?int $ttl = null, bool $forceOverwrite = true): bool
    {
        // Do set operation
        if ($forceOverwrite) {
            $setOperation = $this->redis->set($key, $value);
        } else {
            $setOperation = $this->redis->setnx($key, $value);
        }

        // Bail early
        if (!$setOperation)
            return false;

        if ($ttl)
            return $this->redis->expire($key, $ttl);

        // Everything should be ok at this point
        return true;
    }

    /**
     * Deletes one or multiple items
     * @param \int[] ...$keys
     * @return bool|int true/false if only 1 key given. returns number of deleted keys if multiple keys given.
     */
    public function del(int ...$keys)
    {
        if (!is_array($keys) && func_num_args() > 1) {
            $keys = func_get_args();
        }

        // Bail early
        if (count($keys) < 1)
            return false;

        // If single delete, return a boolean response
        if (count($keys) === 1) {
            return $this->redis->del($keys[0]);
        }

        // At this point, it should be multiple items
        return $this->redis->del($keys);
    }

    /**
     * Renames a key
     * @param string $key
     * @param string $newKey
     * @return mixed
     */
    public function rename(string $key, string $newKey): bool
    {
        return $this->redis->rename($key, $newKey);
    }

    /**
     * Adds an TTL (Time To Live) in second to a key
     * @param string $key
     * @param int $ttl
     * @return bool
     */
    public function expire(string $key, int $ttl): bool
    {
        return $this->redis->expire($key, $ttl);
    }

    /**
     * @return \Redis
     */
    public function getRedis(): \Redis
    {
        return $this->redis;
    }
}