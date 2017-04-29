<?php

namespace  Application\Controllers;

use Application\Core\Controller;
use Application\Models\ModelAdd;

/**
 * Class ControllerAdd
 * @package Application\Controllers
 */
class ControllerAdd extends Controller
{
    /**
     * ControllerAdd constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new ModelAdd();
    }

    /**
     * Action по умолчанию
     */
    public function actionIndex()
    {
        if (!empty($_POST)) {
            $this->actionSave();
        } else {
            $this->view->generate('add_view.php', 'template_view.php');
        }
    }

    /**
     * Добавляет задачу
     */
    public function actionSave()
    {
        $this->model->addTask();

        header('Location:/admin');
    }
}

