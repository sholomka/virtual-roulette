<?php

namespace  Application\Core;

use Application\Core\View;
use Application\Core\ApplicationRegistry;

/**
 * Class Controller - основной контроллер приложения
 * @package Application\Core
 */
abstract class Controller
{
    /**
     * Модель
     *
     * @var
     */
    public $model;

    /**
     * Вид
     *
     * @var \Application\Core\View
     */
    public $view;

    /**
     * Запрос пользователя
     *
     * @var Request
     */
    public $request;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        session_start();
        $this->view = new View();
        $registry = ApplicationRegistry::instance();
        $this->request = $registry->getRequest();
    }

    /**
     * Action по умолчанию
     *
     * @return mixed
     */
    abstract public function actionIndex();
}

