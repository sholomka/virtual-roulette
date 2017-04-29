<?php

namespace Application\Core;


/**
 * Class SessionRegistry реестр на уровне сессии
 * @package Application\Core
 */
class SessionRegistry extends Registry
{
    /**
     * Синглтон
     *
     * @var null
     */
    private static $instance = null;

    /**
     * SessionRegistry constructor.
     */
    private function __construct()
    {
        session_start();
    }

    /**
     * Синглтон
     *
     * @return SessionRegistry|null
     */
    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Извлекает значения из реестра сессии
     *
     * @param $key
     * @return null
     */
    protected function get($key)
    {
       if (isset($_SESSION[__CLASS__][$key])) {
           return $_SESSION[__CLASS__][$key];
       }

       return null;
    }

    /**
     * Добавляет значение в реестр сессии
     *
     * @param $key
     * @param $val
     */
    protected function set($key, $val)
    {
       $_SESSION[__CLASS__][$key] = $val;
    }

    /**
     * Проверяет есть ли какие-то данные в сессии
     *
     * @return bool
     */
    public function isEmpty() {
        if (empty($_SESSION)) {
            return true;
        }

        return false;
    }
}