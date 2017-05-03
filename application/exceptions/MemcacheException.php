<?php

namespace Application\Exceptions;

/**
 * Class MemcacheException - класс ошибок Memcache
 * @package Application\Exceptions
 */
class MemcacheException extends \Exception
{
    /**
     * MemcacheException constructor.
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }
}