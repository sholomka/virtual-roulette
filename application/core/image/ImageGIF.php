<?php

use Application\Core\Image\Exceptions\FileNotSaveException;
use Application\Core\Image\Exceptions\UnsupportedFormatException;
use Application\Core\Image\Image;

/**
 * Class ImageGIF
 */
class ImageGIF extends Image
{
    /**
     * Настройки по умолчанию
     *
     * @throws UnsupportedFormatException
     */
    public function init()
    {
        if (!self::isSupport()) {
            throw new UnsupportedFormatException('gif');
        }

        $this->setResource(@imagecreatefromgif($this->filePath));
    }

    /**
     * Проверяет поддерживается ли формат GIF
     *
     * @return bool
     */
    public static function isSupport()
    {
        $gdInfo = static::getGDinfo();
        return $gdInfo['GIF Read Support'] && $gdInfo['GIF Create Support'];
    }

    /**
     * Сохраняет изображение в формате gif
     *
     * @param $path - путь, по которому сохранится изображение
     * @return $this
     * @throws FileNotSaveException
     */
    public function save($path)
    {
        $this->createDirIfNotExists($path);

        if (!imagegif($this->getResource(), $path)) {
            throw new FileNotSaveException($path);
        }

        return $this;
    }
}