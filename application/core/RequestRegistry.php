<?php

namespace Application\Core;

use  Application\Exceptions\AppException;
use  Application\Core\Request;
use  Application\Core\Registry;

/**
 * Class RequestRegistry - реестр запросов
 * @package Application\Core
 */
class RequestRegistry extends Registry
{
    /**
     * Синглтон
     *
     * @var null
     */
    private static $instance = null;

    /**
     * Массив для значений реестра
     *
     * @var array
     */
    private $values = [];


    /**
     * RequestRegistry constructor.
     */
    private function __construct() {}

    /**
     * Синглтон
     *
     * @return ApplicationRegistry|null
     */
    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Извлекает значения из реестра
     *
     * @param $key
     * @return mixed|null
     */
    protected function get($key)
    {
        if (isset($this->values[$key])) {
            return $this->values[$key];
        }

        return null;
    }

    /**
     * Добавляет значение в реестр
     *
     * @param $key
     * @param $val
     */
    protected function set($key, $val)
    {
        $this->values[$key] = $val;
    }

    /**
     * Получает объект запроса пользователя
     *
     * @return mixed|null
     */
    public static function getRequest()
    {
        $instance = self::instance();

        if (is_null($instance->get('request'))) {
            $instance->set('request', new Request());
        }

        return $instance->get('request');
    }
}