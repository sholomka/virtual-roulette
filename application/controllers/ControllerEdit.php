<?php

namespace  Application\Controllers;

use Application\Core\Controller;
use Application\Models\ModelEdit;
use Application\Core\File\User;

/**
 * Class ControllerEdit
 * @package Application\Controllers
 */
class ControllerEdit extends Controller
{
    /**
     * ControllerEdit constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new ModelEdit();
    }

    /**
     * Action по умолчанию
     */
    public function actionIndex()
    {
        $secondUrlPart = $this->request->getUrlPart(2);

        if (!empty($secondUrlPart)) {
            $id = $secondUrlPart;
            $data = $this->model->getDataById($id);
        }

        if (!empty($_POST)) {
            $this->actionSave();
        } else {
            $this->view->generate('edit_view.php', 'template_view.php', $data);
        }
    }

    /**
     * Сохранение ззадачи
     */
    public function actionSave()
    {
        $this->model->editTask($this->request);
        header('Location:/admin');
    }

    /**
     * Ajax action для загрузки файла на сервер
     */
    public function actionImageUpload()
    {
        $file = new User();
        $array = ['status' => 'success', 'filename' => $file->getSavedFileName()];
        header('Content-Type', 'application/json;charset=utf-8');
        $file->upload();
        echo  json_encode($array);
    }
}

