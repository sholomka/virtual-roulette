<?php

namespace  Application\Controllers;

use Application\Core\Controller;
use Application\Models\ModelAdmin;

/**
 * Class ControllerAdmin
 * @package Application\Controllers
 */
class ControllerAdmin extends Controller
{
    /**
     * ControllerAdmin constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new ModelAdmin();
    }

    /**
     * Action по умолчанию
     */
    public function actionIndex()
    {
        $data = $this->model->getData();
        $this->view->generate('admin_view.php', 'template_view.php', $data);
    }

    /**
     * Action разлогина пользователя
     */
    public function actionLogout()
    {
        session_start();
        session_destroy();
        header('Location:/');
    }
}

