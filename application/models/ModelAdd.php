<?php

namespace  Application\Models;

use Application\Core\Model;

/**
 * Class ModelAdd
 * @package Application\Models
 */
class ModelAdd extends Model
{
    /**
     * Запрос на добавление задачи
     * @var string
     */
    public static $addTask = "INSERT INTO tasks
                              (name, email, description, image)
                              values(?, ?, ?, ?)";

    /**
     * Добавляет задачу
     */
    public function addTask()
    {
        $name = $this->request->getProperty('name');
        $email = $this->request->getProperty('email'); ;
        $description = $this->request->getProperty('description');
        $image = $this->request->getProperty('image');
        $this->doStatement(self::$addTask, [$name, $email, $description, $image]);
    }
}

