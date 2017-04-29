<?php

namespace  Application\Controllers;

use Application\Core\Controller;
use Application\Core\SessionRegistry;
use Application\Models\ModelMain;

/**
 * Class ControllerMain
 * @package Application\Controllers
 */
class ControllerMain extends Controller
{
    /**
     * ControllerMain constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new ModelMain();
    }

    /**
     * Action по умолчанию
     */
    public function actionIndex()
    {

        $sessionRegistry = SessionRegistry::instance();

        if ($sessionRegistry->isEmpty()) {
            $this->view->generate('login_view.php', 'template_view.php');
        } else {
            $this->view->generate('main_view.php', 'template_view.php');
        }



    }
}

