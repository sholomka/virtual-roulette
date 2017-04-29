<?php

namespace Application\Exceptions;

/**
 * Class AppException - класс ошибок приложения
 * @package Application\Exceptions
 */
class AppException extends \Exception
{
    /**
     * AppException constructor.
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }
}