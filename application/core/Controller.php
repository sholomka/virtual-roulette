<?php

namespace  Application\Core;

use Application\Core\View;
use Application\Core\ApplicationRegistry;
use Application\Core\SessionRegistry;
use Application\Core\RequestRegistry;

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
    protected $model;

    /**
     * Вид
     *
     * @var \Application\Core\View
     */
    protected $view;

    /**
     * Запрос пользователя
     *
     * @var Request
     */
    protected $request;

    /**
     * Реестр уровня сессии
     *
     * @var \Application\Core\SessionRegistry|null
     */
    protected $sessionRegistry;


    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->view = new View();
        $this->sessionRegistry = SessionRegistry::instance();
        $this->applicationRegistry = ApplicationRegistry::instance();
        $this->request = RequestRegistry::instance()->getRequest();
    }

    /**
     * Action по умолчанию
     *
     * @return mixed
     */
    abstract public function actionIndex();
}

