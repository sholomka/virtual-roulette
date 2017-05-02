<?php

namespace Application\Core;

use Application\Core\User;

/**
 * Class SessionRegistry реестр на уровне сессии
 * @package Application\Core
 */
class SessionRegistry extends Registry
{
    /**
     * Время бездействия, после которого юзер разлогинится
     */
    const LOGOUT_TIME = 300;

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

        if (!isset($_SESSION['timestamp'])) {
            $this->set('timestamp', time());
        } else if (time() - $this->get('timestamp') > self::LOGOUT_TIME){
            User::logout();
        }
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
     * @param $user
     */
    public function setUser($user)
    {
        self::instance()->set('user', $user);
    }

    /**
     * @return null
     */
    public function getUser()
    {
        return self::instance()->get('user');
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return self::instance()->getUser()->id;
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