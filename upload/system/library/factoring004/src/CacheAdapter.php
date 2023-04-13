<?php

namespace BnplPartners\Factoring004Payment;

use Psr\SimpleCache\CacheInterface;

class CacheAdapter implements CacheInterface
{

    private $cache;

    public function __construct(\Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
    }

    /**
     * @inheritDoc
     */
    public function getMultiple($keys, $default = null)
    {
        $result = [];
        foreach ($keys as $key) {
            if ($value = $this->cache->get($key)) {
                $result[] = $value;
            } else {
                $result[] = $default;
            }
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function setMultiple($values, $ttl = null)
    {
        foreach( $values as $key => $value) {
            $this->cache->set($key, $value);
        }
    }

    /**
     * @inheritDoc
     */
    public function deleteMultiple($keys)
    {
        foreach ($keys as $key) {
            $this->cache->delete($key);
        }
    }

    /**
     * @inheritDoc
     */
    public function has($key)
    {
        return (bool) $this->cache->get($key);
    }

    public function get($key, $default = null)
    {
        if ($expire = $this->cache->get($key . '_expire')) {
            if ($expire < time()) {
                return $default;
            }
        }
        if ($value = $this->cache->get($key)) {
            return $value;
        }
        return $default;
    }

    public function set($key, $value, $ttl = null)
    {
        if (is_int($ttl)) {
            $this->cache->set($key . '_expire', $ttl);
        }
        return $this->cache->set($key, $value);
    }

    public function delete($key)
    {
        return $this->cache->delete($key);
    }
}