<?php

namespace  Application\Core\Image\Exceptions;

/**
 * Class Models_Image_Exceptions_FileNotSaveException
 */
class FileNotSaveException extends \Exception
{
    /**
     * Models_Image_Exceptions_FileNotSaveException constructor.
     * @param string $path
     */
    public function __construct($path)
    {
        $this->message = "File: $path not saved";
    }
}