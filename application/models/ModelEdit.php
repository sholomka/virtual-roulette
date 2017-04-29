<?php

namespace  Application\Models;

use Application\Core\Model;
use Application\Core\Request;

/**
 * Class ModelEdit
 * @package Application\Models
 */
class ModelEdit extends Model
{
    /**
     * @var string
     */
    public static $editTask = "UPDATE tasks
                               SET  
                                   name = ?,
                                   email = ?,
                                   description = ?,
                                   image = ?,
                                   status = ?
                               WHERE id = ?";

    /**
     * @var string
     */
    public static $getTaskById = "SELECT
                                      id,
                                      name, 
                                      email, 
                                      description, 
                                      image, 
                                      status
                                  FROM tasks
                                  WHERE id = ?";

    /**
     * Редактирование задачи
     */
    public function editTask()
    {
        $name = $this->request->getProperty('name');
        $email = $this->request->getProperty('email'); ;
        $description = $this->request->getProperty('description');
        $image = $this->request->getProperty('image');
        $id = $this->request->getProperty('id');
        $status = $this->request->getProperty('status') == 'on' ? 1 : 0;

        $stmt = $this->doStatement(self::$editTask, [
            $name,
            $email,
            $description,
            $image,
            $status,
            $id
        ]);
    }

    /**
     * Получение задачи по ID
     *
     * @return array
     */
    public function getDataById($id)
    {
        $stmt = $this->doStatement(self::$getTaskById, [$id]);

        if ($result = $stmt->fetch(\PDO::FETCH_OBJ)) {
            return $result;
        }
    }
}

