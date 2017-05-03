<?php

namespace  Application\Core;

use Application\Exceptions\MemcacheException;

use Application\Core\ApplicationRegistry;

class MemcacheRegistry extends Registry
{
    /**
     * Таймаут по умолчанию
     */
    const MEMCACHE_TIMEOUT = 86400;

    /**
     * Хост по умолчанию
     */
    const MEMCACHE_HOST = 'localhost';

    /**
     * Порт по умолчанию
     */
    const MEMCACHE_PORT = 11211;

    /**
     * Объект Memcache
     *
     * @var \Memcache
     */
    protected $_memcache;

    /**
     * Есть ли соединение
     *
     * @var bool
     */
    protected $_isConnected = false;

    /**
     * MemcacheRegistry constructor.
     * @throws MemcacheException
     */
    public function __construct()
    {
        try {
            $this->_memcache = new \Memcache();
            $this->_isConnected = $this->_memcache->connect(self::MEMCACHE_HOST, self::MEMCACHE_PORT);
        } catch (\Exception $e) {
            throw new MemcacheException($e->getMessage());
        }

        return $this;
    }

    /**
     * Получение ключа
     *
     * @param string $key
     */
    public function get($key)
    {
        if (!($this->_isConnected && $this->_memcache->get($key))) {
            throw new \Exception('Memcache not connected or no such key');
        }

        return $this->_memcache->get($key);
    }

    /**
     * Сохранение ключа
     *
     * @param string $key
     * @param mixed $value
     * @param integer $timeout
     */
    public function set($key, $value, $timeout = self::MEMCACHE_TIMEOUT)
    {
        if ($this->_isConnected) {
            $this->_memcache->set($key, $value, MEMCACHE_COMPRESSED, $timeout);
        }
        return $this;
    }

    /**
     * Удаление ключа
     *
     * @param string $key
     */
    public function delete($key)
    {
        if ($this->_isConnected) {
            $this->_memcache->delete($key);
        }

        return $this;
    }
}