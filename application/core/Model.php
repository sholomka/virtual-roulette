<?php

namespace  Application\Core;

use Application\Core\ApplicationRegistry;
use Application\Core\SessionRegistry;
use Application\Core\RequestRegistry;

/**
 * Class Model - основная модель приложения
 * @package Application\Core
 */
abstract class Model
{
    /**
     * Подключение к PDO    
     *
     * @var \PDO
     */
    private static $DB;

    /**
     * @var array
     */
    private static $statements = [];

    /**
     * Реестр уровня сессии
     *
     * @var \Application\Core\SessionRegistry|null
     */
    protected static $sessionRegistry;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->applicationRegistry = ApplicationRegistry::instance();
        self::$sessionRegistry = SessionRegistry::instance();
        $this->applicationRegistry ->init();
        $this->request = RequestRegistry::instance()->getRequest();
        $this->connectDb();
    }

    /**
     * Соединение с базой
     *
     * @return $this
     */
    public function connectDb()
    {
        $dsn = $this->applicationRegistry->getDSN();
        $username = $this->applicationRegistry->getUserName();
        $password = $this->applicationRegistry->getPassword();
        $this->applicationRegistry->ensure($dsn, 'DSN не определен');

        try {
            self::$DB = new \PDO($dsn, $username, $password);
            self::$DB->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\Pdoexception $e) {
            echo "database error: " . $e->getmessage();
            die();
        }

        self::$DB->query('set names utf8');

        return $this;
    }

    /**
     * Подготовка выражения
     *
     * @param $statement
     * @return mixed|\PDOStatement
     */
    private function prepareStatement($statement)
    {
        if (isset(self::$statements[$statement])) {
            return self::$statements[$statement];
        }

        $stmtHandle = self::$DB->prepare($statement);
        self::$statements[$statement] = $stmtHandle;
        return $stmtHandle;
    }

    /**
     * Исполнения выражения
     *
     * @param $statement
     * @param array|null $values
     * @return mixed|\PDOStatement
     */
    protected function doStatement($statement, array $values = [])
    {
        $sth = $this->prepareStatement($statement);
        $sth->closeCursor();

        try {
            self::$DB->beginTransaction();
            $result = $sth->execute($values);

            $this->id = self::$DB->lastInsertId();

            self::$DB->commit();
        } catch (\PDOException $e) {
            self::$DB->rollback();
            echo "Database error: " . $e->getMessage();
            die();
        }

        if (!$result) {
            $info = $sth->errorInfo();
            printf("Database error %d %s", $info[1], $info[2]);
            die();
        }

        return $sth;
    }

    /**
     * __destruct
     */
    public function __destruct()
    {
        self::$DB = null;
    }
}

