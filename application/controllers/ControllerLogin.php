<?php

namespace  Application\Controllers;

use Application\Core\Controller;

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
        $login = $this->request->getProperty('login');
        $password = $this->request->getProperty('password');

        if ($login === 'admin' && $password === '123') {
            session_start();
            $_SESSION['admin'] = $password;
            header('Location:/admin/');
        }

        $this->view->generate('login_view.php', 'template_view.php');
    }
}

