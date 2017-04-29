<?php

namespace  Application\Core\Image\Exceptions;

/**
 * Class InvalidFileException
 * @package Application\Core\Image\Exceptions
 */
class InvalidFileException extends \Exception
{

    /**
     * InvalidFileException constructor.
     * @param string $path
     */
    public function __construct($path)
    {
        $this->message = "Ivalid file: $path";
    }
}