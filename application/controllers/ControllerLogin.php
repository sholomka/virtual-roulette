<?php

namespace  Application\Controllers;

use Application\Core\Controller;
use Application\Core\User;

/**
 * Class ControllerLogin
 * @package Application\Controllers
 */
class ControllerLogin extends Controller
{
    /**
     * Action по умолчанию
     * Логин пользователя
     * Для упрощения сделано не через БД
     */
    public function actionIndex()
    {
        if ($this->request->isPost()) {
            $user = new User();
            $username = $this->request->getProperty('login');
            $password = $this->request->getProperty('password');

            if ($user->authorize($username, $password)) {
                header('Location:/admin/');
            }
        }

        $this->view->generate('login_view.php', 'template_view.php');
    }
}

