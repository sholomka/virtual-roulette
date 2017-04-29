<?php

namespace  Application\Core\Image\Exceptions;

/**
 * Class FileNotFoundException
 * @package Application\Core\Image\Exceptions
 */
class FileNotFoundException extends \Exception
{
    const MESSAGE = 'File not found';

    /**
     * FileNotFoundException constructor.
     */
    public function __construct()
    {
        $this->message = self::MESSAGE;
    }
}