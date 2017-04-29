<?php

namespace  Application\Core\Image\Exceptions;

/**
 * Class UnsupportedFormatException
 * @package Application\Core\Image\Exceptions
 */
class UnsupportedFormatException extends \Exception
{
    /**
     * UnsupportedFormatException constructor.
     * @param string $format
     */
    public function __construct($format)
    {
        $this->message = "This image format ($format) is not supported by your version of GD library";
    }
}