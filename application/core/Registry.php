<?php

namespace Application\Core;

/**
 * Class Registry - основной реестр
 * @package Application\Core
 */
abstract class Registry
{
    /**
     * Получить значение по ключу
     *
     * @param $key
     * @return mixed
     */
    abstract protected function get($key);

    /**
     * Сохранить значение в реестре
     *
     * @param $key
     * @param $val
     * @return mixed
     */
    abstract protected function set($key, $val);
}