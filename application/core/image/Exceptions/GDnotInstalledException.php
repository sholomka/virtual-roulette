<?php

namespace  Application\Core\Image\Exceptions;

/**
 * Class GDnotInstalledException
 * @package Application\Core\Image\Exceptions
 */
class GDnotInstalledException extends \Exception
{

    /**
     * GDnotInstalledException constructor.
     */
    public function __construct()
    {
        $this->message = "The GD library is not installed";
    }
}