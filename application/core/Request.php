<?php

namespace  Application\Core;

/**
 * Class Request
 * @package Application\Core
 */
class Request
{
    /**
     * @var
     */
    private $properties;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Инициализация объекта запроса
     */
    public function init()
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            $this->properties = $_REQUEST;
        }
    }

    /**
     * Получение свойств запроса
     *
     * @param $key
     * @param null $default
     * @return null
     */
    public function getProperty($key, $default = null)
    {
        if (isset($this->properties[$key])) {
            return $this->properties[$key];
        }

        return $default;
    }

    /**
     * Установка свойств запроса
     *
     * @param $key
     * @param $val
     */
    public function setProperty($key, $val)
    {
        $this->properties[$key] = $val;
    }

    /**
     * Получение свойств массива $_SERVER
     *
     * @param $key
     * @return null
     */
    public function getServer($key)
    {
        if (isset($_SERVER[$key])) {
            return $_SERVER[$key];
        }

        return null;
    }

    /**
     * Получение части URL
     *
     * @param $part
     * @return null
     */
    public function getUrlPart($part)
    {
        $routes = explode('/', $this->getServer('REQUEST_URI'));

        if (!empty($routes[$part])) {
            if (strpos($routes[$part], '?') !== false) {
                $routes[$part] = array_shift(explode('?', $routes[$part]));
            }

            return $routes[$part];
        }

        return null;
    }
}

