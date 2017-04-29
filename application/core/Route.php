<?php

namespace  Application\Core;

use Application\Core\ApplicationRegistry;

/**
 * Class Route - основной роутер приложения
 * @package Application\Core
 */
class Route
{
    /**
     * Action по умолчанию
     */
    const ACTION_NAME = 'Index';

    /**
     * Контроллер по умолчанию
     */
    const CONTROLLER_NAME = 'Main';

    /**
     * Разбор URL
     */
    public static function start()
    {
        $registry = ApplicationRegistry::instance();
        $request = $registry->getRequest();
        $actionName = self::ACTION_NAME;
        $controllerName = self::CONTROLLER_NAME;
        $firstUrlPart = $request->getUrlPart(1);
        $secondUrlPart = $request->getUrlPart(2);

        if (!empty($firstUrlPart)) {
            $controllerName = mb_convert_case($firstUrlPart, MB_CASE_TITLE, "UTF-8");

            if (strpos($controllerName, '?') !== false) {
                $controllerName = array_shift(explode('?', $controllerName));
            }
        }

        if (!empty($secondUrlPart)) {
            $actionName = mb_convert_case($secondUrlPart, MB_CASE_TITLE, "UTF-8");
        }

        if (is_numeric($actionName)) {
            $actionName = self::ACTION_NAME;
        }

        $modelName = 'Model' . $controllerName;
        $controllerName = 'Controller' . $controllerName;
        $actionName = 'action' . $actionName;
        $modelFile = $modelName . '.php';
        $modelPath = 'application/models/' . $modelFile;

        if (file_exists($modelPath)) {
            include_once($modelPath);
        }

        $controllerFile = $controllerName . '.php';
        $controllerPath = 'application/controllers/' . $controllerFile;

        if (file_exists($controllerPath)) {
            include_once($controllerPath);
        } else {
            self::errorPage404();
        }

        $controllerNameSpacePath = '\\Application\\Controllers\\';
        $controllerName = $controllerNameSpacePath . $controllerName;
        $controler = new $controllerName();
        $action = $actionName;

        if (method_exists($controler, $action)) {
            $controler->$action();
        } else {
            self::errorPage404();
        }
    }

    /**
     * Ошибка 404
     */
    public static function errorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header('Status: 404 Not Found');
        header('Location: ' . $host . '404');
    }
}
