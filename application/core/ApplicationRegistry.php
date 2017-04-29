<?php

namespace Application\Core;

use  Application\Exceptions\AppException;
use  Application\Core\Request;
use  Application\Core\Registry;

/**
 * Class ApplicationRegistry - основной реест приложения
 * @package Application\Core
 */
class ApplicationRegistry extends Registry
{
    /**
     * Синглтон
     *
     * @var null
     */
    private static $instance = null;

    /**
     * Путь к конфигу
     *
     * @var
     */
    private $config;

    /**
     * Массив для значений реестра
     *
     * @var array
     */
    private $values = [];

    /**
     * Запрос пользователя
     *
     * @var
     */
    private $request;

    /**
     * ApplicationRegistry constructor.
     */
    private function __construct()
    {
        $this->config = realpath(implode(DIRECTORY_SEPARATOR, array(__DIR__, '..', 'config', 'config.php')));
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
     * Получает настройки из конфига
     */
    private function getOptions()
    {
        $this->ensure(file_exists($this->config), 'Файл конфигурации не найден');
        $options = require_once($this->config);

        $dsn = 'mysql:host='. $options['db']['host'] .';dbname='. $options['db']['dbname'] .';charset='. $options['db']['charset'];
        $username = $options['db']['username'];
        $password = $options['db']['password'];

        self::setDSN($dsn);
        self::setUserName($username);
        self::setPassword($password);
    }

    /**
     * Устанавливает DSN
     *
     * @param $dsn
     */
    private static function setDSN($dsn)
    {
        self::instance()->set('dsn', $dsn);
    }

    /**
     * Устанавливает имя пользователя
     *
     * @param $username
     */
    private static function setUserName($username)
    {
        self::instance()->set('username', $username);
    }

    /**
     * Устанавливает пароль
     *
     * @param $password
     */
    private static function setPassword($password)
    {
        self::instance()->set('password', $password);
    }

    /**
     * Вывод ошибок
     *
     * @param $expr
     * @param $message
     * @throws \Exception
     */
    public function ensure($expr, $message)
    {
        if (!$expr) {
            throw new AppException($message);
        }
    }

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
     * Получает DSN
     *
     * @return mixed|null
     */
    public static function getDSN()
    {
        return self::instance()->get('dsn');
    }

    /**
     * Получате имя пользователя
     *
     * @return mixed|null
     */
    public static function getUserName()
    {
        return self::instance()->get('username');
    }

    /**
     * Получает пароль
     *
     * @return mixed|null
     */
    public static function getPassword()
    {
        return self::instance()->get('password');
    }

    /**
     * Получает объект запроса пользователя
     *
     * @return \Application\Core\Request
     */
    public static function getRequest()
    {
        $instance = self::instance();

        if (is_null($instance->request)) {
            $instance->request = new Request();
        }

        return $instance->request;
    }

    /**
     *  Инициализация реестра и получения настроек
     */
    public function init()
    {
        $dsn = self::getDSN();

        if (!is_null($dsn)) {
            return;
        }

        $this->getOptions();
    }
}