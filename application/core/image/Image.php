<?php

namespace  Application\Core\Image;

use Application\Core\Image\Exceptions\FileNotFoundException;
use Application\Core\Image\Exceptions\InvalidFileException;
use Application\Core\Image\Exceptions\GDnotInstalledException;
use Application\Core\File\File;

/**
 * Class Models_File_Image
 */
class Image extends File
{
    const PNG = 'image/png';

    const JPEG = 'image/jpeg';

    const GIF = 'image/gif';

    const THUMBNAIL_WIDTH = 320;

    const THUMBNAIL_HEIGHT = 240;

    /**
     * Ресурс изображения
     *
     * @var
     */
    private $resource;

    /**
     * Массив с информацией об изображении,
     * который возвращает ф-ция getimagesize()
     *
     * @var
     */
    private $imageInfo;

    /**
     * Качество по умолчанию
     *
     * @var int
     */
    private static $quality = 85;

    /**
     * Информация о поддерживаемых типах изображений
     *
     * @var
     */
    private static $gdInfo;

    /**
     * Направление поворота картинки по умолчанию
     *
     * @var int
     */
    private static $rotateDirection = -1;

    /**
     * Yгол поворота картинки по умолчанию
     *
     * @var int
     */
    private static $degrees = 90;

    /**
     * Путь к файлу с изображением
     */
    protected  $filePath;

    /**
     * Image constructor.
     * @param $filePath - путь к файлу с изображением
     * @throws FileNotFoundException
     * @throws InvalidFileException
     */
    public function __construct($filePath)
    {
        if (!parent::isFileExists($filePath)) {
            throw new FileNotFoundException();
        }

        $this->filePath = $filePath;

        $imageInfo = $this->getImageInfo();

        if (!is_array($imageInfo)) {
            throw new InvalidFileException($filePath);
        }

        $this->init();
    }

    /**
     * Init
     */
    protected function init()
    {
    }

    /**
     * Создает экземпляры классов ImageJPG, ImagePNG, ImageGIF
     * в зависимости от типа изображения
     * @param $filePath
     * @return Models_Image_ImageGIF|Models_Image_ImageJPG|Models_Image_ImagePNG
     * @throws GDnotInstalledException
     * @throws InvalidFileException
     */
    public static function createImage($filePath)
    {
        $image = new self($filePath);

        if (!self::isSupportedGD()) {
            throw new GDnotInstalledException();
        }

        $imageInfo = $image->getImageInfo();

        $mimeType = $imageInfo['mime'];

        switch ($mimeType) {
            case self::JPEG:
                return new Models_Image_ImageJPG($filePath);
            case self::PNG:
                return new Models_Image_ImagePNG($filePath);
            case self::GIF:
                return new Models_Image_ImageGIF($filePath);
            default:
                throw new InvalidFileException($filePath);
        }
    }

    /**
     * Получает информацию об изображении
     *
     * @return array
     */
    public function getImageInfo()
    {
        if (!isset($this->imageInfo)) {
            $this->imageInfo = @getimagesize($this->getFilePath());
        }

        return $this->imageInfo;
    }

    /**
     * Получает путь к изображению
     *
     * @return mixed
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     *  Устанавливает идентификатор изображения
     *
     * @param $resource
     * @return mixed
     */
    public function setResource($resource)
    {
        return $this->resource = $resource;
    }

    /**
     * Возвращает идентификатор изображения
     *
     * @return mixed
     */
    protected function getResource()
    {
        return $this->resource;
    }

    /**
     * Удаляет идентификатор изображения
     */
    public function destroyResource()
    {
        imagedestroy($this->resource);
    }

    /**
     * Возвращает качество изображения
     *
     * @return int
     */
    protected static function getQuality()
    {
        return self::$quality;
    }

    /**
     * Создает папку, если ее нет
     *
     * @param $path
     */
    protected function createDirIfNotExists($path)
    {
        parent::setDestination($path);

        $dir = parent::getDirName();

        if (!parent::isDirExists($dir)) {
            parent::createDir($dir);
        }
    }

    /**
     * Производит кроп изображения, то есть
     * вырезает из него произвольную прямоугольную область.
     *
     * @param $x
     * @param $y
     * @param $width
     * @param $height
     * @return $this
     */
    public function crop($x, $y, $width, $height)
    {
        $targ_w = self::THUMBNAIL_WIDTH;
        $targ_h = self::THUMBNAIL_HEIGHT;

        $newImageResource = ImageCreateTrueColor($targ_w, $targ_h);

        imageAlphaBlending($newImageResource, false);
        imageSaveAlpha($newImageResource, true);
        imagecopyresampled($newImageResource, $this->getResource(), 0, 0, $x, $y, $targ_w, $targ_h, $width, $height);

        $this->setResource($newImageResource);

        return $this;
    }

    /**
     * Проверяет поддерживается ли GD библиотека
     *
     * @return bool
     */
    public static function isSupportedGD()
    {
        return function_exists('gd_info');
    }

    /**
     * Возвращает две первые цифры
     * версии php, разделённые точкой.
     * Например: 5.2, 5.3
     *
     * @return mixed
     */
    public static function getShortPHPVersion()
    {
        $matches = array();
        preg_match("@^\d\.\d@", phpversion(), $matches);
        return $matches[0];
    }

    /**
     * Возвращает результат работы функции gd_info()
     * или false, если библиотека GD не доступна
     *
     * @return array|bool
     */
    protected static function getGDinfo()
    {
        if (!self::isSupportedGD()) {
            return false;
        }

        if (!isset(self::$gdInfo)) {
            self::$gdInfo = gd_info();
        }

        return self::$gdInfo;
    }

    /**
     * Поворот изображения с заданным углом
     *
     * @return $this
     */
    public function rotate()
    {
        $source = $this->getResource();
        $rotate = imagerotate($source, self::$degrees * self::$rotateDirection, 0);
        $this->setResource($rotate);

        return $this;
    }
}
