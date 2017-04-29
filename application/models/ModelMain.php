<?php

namespace  Application\Models;

use Application\Core\Model;

/**
 * Class ModelMain
 * @package Application\Models
 */
class ModelMain extends Model
{

    /**
     * @var string
     */
    public static $getTasks = "SELECT 
                                  id,
                                  name, 
                                  email, 
                                  description, 
                                  image, 
                                  status
                               FROM tasks";

    /**
     * Получение всех задач
     *
     * @return array
     */
    public function getData()
    {
        $stmt = $this->doStatement(self::$getTasks);

        if ($result = $stmt->fetchAll(\PDO::FETCH_OBJ)) {
            return $result;
        }
    }
}

