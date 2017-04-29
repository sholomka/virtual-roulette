<?php

namespace  Application\Core;

use Application\Core\ApplicationRegistry;

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
     * Model constructor.
     */
    public function __construct()
    {
        $registry = ApplicationRegistry::instance();
        $registry->init();
        $dsn = $registry->getDSN();
        $username = $registry->getUserName();
        $password = $registry->getPassword();
        $this->request = $registry->getRequest();
        $registry->ensure($dsn, 'DSN не определен');
        self::$DB = new \PDO($dsn, $username, $password);
        self::$DB->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
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
        $dbResult = $sth->execute($values);
        return $sth;
    }
}

