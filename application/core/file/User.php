<?php

namespace Application\Core\File;

use Application\Core\File\File;


/**
 * Class User
 */
class User extends File
{
    /**
     * Ширина иконки
     */
    const THUMBNAIL_WIDTH = 320;

    /**
     * Высота иконки
     */
    const THUMBNAIL_HEIGHT = 240;

    /**
     * @var array
     */
    protected $charsetLetters = array(
        'а' => 'a',
        'б' => 'b',
        'в' => 'v',
        'г' => 'g',
        'д' => 'd',
        'е' => 'e',
        'ё' => 'e',
        'ж' => 'zh',
        'з' => 'z',
        'и' => 'i',
        'й' => 'i',
        'к' => 'k',
        'л' => 'l',
        'м' => 'm',
        'н' => 'n',
        'о' => 'o',
        'п' => 'p',
        'р' => 'r',
        'с' => 's',
        'т' => 't',
        'у' => 'u',
        'ф' => 'f',
        'х' => 'kh',
        'ц' => 'ts',
        'ч' => 'ch',
        'ш' => 'sh',
        'щ' => 'shch',
        'ы' => 'y',
        'ъ' => '',
        'ь' => '',
        'э' => 'e',
        'ю' => 'iu',
        'я' => 'ia',
        ' ' => '-',
        '0' => '0',
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        'q' => 'q',
        'w' => 'w',
        'e' => 'e',
        'r' => 'r',
        't' => 't',
        'y' => 'y',
        'u' => 'u',
        'i' => 'i',
        'o' => 'o',
        'p' => 'p',
        'a' => 'a',
        's' => 's',
        'd' => 'd',
        'f' => 'f',
        'g' => 'g',
        'h' => 'h',
        'j' => 'j',
        'k' => 'k',
        'l' => 'l',
        'z' => 'z',
        'x' => 'x',
        'c' => 'c',
        'v' => 'v',
        'b' => 'b',
        'n' => 'n',
        'm' => 'm',
    );

    /**
     * User constructor.
     */
    public function __construct()
    {
        $originalPath = APPLICATION_PATH .  implode('/', ['images']) . DIRECTORY_SEPARATOR;

        if (array_key_exists(parent::$fileKeyName, $_FILES)) {
            $this->savedFileName = $this->transliterate(basename($_FILES[parent::$fileKeyName]['name']));
            $this->destination = $originalPath . $this->savedFileName;
        }
    }

    /**
     * Транслитерация имени файла
     *
     * @param $string
     * @return mixed
     */
    private function transliterate($string)
    {
        $result = '';
        $string = trim(mb_strtolower($string, 'UTF-8'));
        $chars = $this->utf8Split($string);

        if ($chars) {
            foreach ($chars as $c) {
                if (array_key_exists($c, $this->charsetLetters)) {
                    $result .= $this->charsetLetters[$c];
                } else {
                    $result .= $c;
                }
            }
        }

        return preg_replace('/\-+/', '-', $result);
    }

    /**
     * Разбивка имени посимвольно в массив
     *
     * @param $str
     * @param int $len
     * @return array
     */
    private function utf8Split($str, $len = 1)
    {
        $arr = array();
        $strLen = mb_strlen($str, 'UTF-8');
        for ($i = 0; $i < $strLen; $i++) {
            $arr[] = mb_substr($str, $i, $len, 'UTF-8');
        }
        return $arr;
    }
}