<?php

namespace  Application\Controllers;

use Application\Core\Controller;

/**
 * Class Controller404
 * @package Application\Controllers
 */
class Controller404 extends Controller
{
    /**
     * Action по умолчанию
     */
    public function actionIndex()
    {
        $this->view->generate('404_view.php', 'template_view.php');
    }
}

