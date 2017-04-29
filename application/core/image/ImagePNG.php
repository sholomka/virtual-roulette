<?php

use Application\Core\Image\Exceptions\UnsupportedFormatException;
use Application\Core\Image\Exceptions\FileNotSaveException;
use Application\Core\Image\Image;

/**
 * Class Models_Image_ImagePNG
 */
class Models_Image_ImagePNG extends Image
{
    /**
     * Настройки по умолчанию
     *
     * @throws UnsupportedFormatException
     */
    public function init()
    {
        if (!self::isSupport()) {
            throw new UnsupportedFormatException('png');
        }

        $this->setResource(@imagecreatefrompng($this->filePath));
    }

    /**
     * Проверяет, поддерживается ли формат png
     *
     * @return boolean
     */
    public static function isSupport()
    {
        $gdInfo = static::getGDinfo();
        return (bool)$gdInfo['PNG Support'];
    }

    /**
     * Сохраняет изображение в формате png
     *
     * @param $path  - путь, по которому сохранится изображение
     * @return $this
     * @throws FileNotSaveException
     */
    public function save($path)
    {
        $this->createDirIfNotExists($path);

        if (!imagePng($this->getResource(), $path, self::getQuality())) {
            throw new FileNotSaveException($path);
        };

        return $this;
    }

    /**
     * Возвращает качество png-изображения
     *
     * @return int
     */
    public static function getQuality()
    {
        return 9 - round(parent::getQuality() / 10);
    }
}