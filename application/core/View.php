<?php

namespace  Application\Core;

/**
 * Class View - основной класс вида приложения
 * @package Application\Core
 */
class View
{
    /**
     * Генерация шаблона
     *
     * @param $contentView
     * @param $templateView
     * @param null $data
     */
    public function generate($contentView, $templateView, $data = null)
    {
        include_once('application/views/' . $templateView);
    }
}

