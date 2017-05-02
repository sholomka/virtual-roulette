<?php

namespace  Application\Core;
use Application\Core\Model;

class User extends Model
{

    /**
     * ID авторизированного пользователя
     *
     * @var
     */
    private $user_id;

    /**
     * Авторизированный пользователь
     *
     * @var
     */
    private $user;


    /**
     * Флаг авторизации пользователя
     *
     * @var bool
     */
    private $is_authorized = false;

    /**
     * Проверяет авторизирован ли пользователь
     *
     * @return bool
     */
    public static function isAuthorized()
    {
        if (!empty(static::$sessionRegistry->getUser())) {
            return (bool) static::$sessionRegistry->getUser();
        }
        return false;
    }

    /**
     * Хеширование пароля
     *
     * @param $password
     * @param null $salt
     * @param int $iterations
     * @return array
     */
    public function passwordHash($password, $salt = null, $iterations = 10)
    {
        $salt || $salt = uniqid();
        $hash = md5(md5($password . md5(sha1($salt))));

        for ($i = 0; $i < $iterations; ++$i) {
            $hash = md5(md5(sha1($hash)));
        }

        return array('hash' => $hash, 'salt' => $salt);
    }

    /**
     * Получение соли дял пароля
     *
     * @param $username
     * @return bool
     */
    public function getSalt($username)
    {
        $query = "SELECT salt 
                  FROM users 
                  WHERE username = :username limit 1";

        $sth = $this->doStatement($query, array(
            ":username" => $username
        ));

        $row = $sth->fetch();
        if (!$row) {
            return false;
        }
        return $row["salt"];
    }

    /**
     * Авторизациия пользователя
     *
     * @param $username
     * @param $password
     * @param bool $remember
     * @return bool
     */
    public function authorize($username, $password, $remember = false)
    {
        $query = "SELECT id, username 
                  FROM users 
                  WHERE username = :username 
                  AND password = :password limit 1";

        $salt = $this->getSalt($username);

        if (!$salt) {
            return false;
        }

        $hashes = $this->passwordHash($password, $salt);

        $sth = $this->doStatement($query, array(
            ":username" => $username,
            ":password" => $hashes['hash'],
        ));

        $this->user = $sth->fetch(\PDO::FETCH_OBJ);

        if (!$this->user) {
            $this->is_authorized = false;
        } else {
            $this->is_authorized = true;
            $this->user_id = $this->user->id;
            $this->saveSession($remember);
        }

        return $this->is_authorized;
    }

    /**
     * Разлогинивает юзера
     */
    public static function logout()
    {
        session_start();
        session_destroy();
        unset($_SESSION);
        header('Location:/login/');
        exit;
    }

    public function saveSession($remember = false, $http_only = true, $days = 1, $hours = 1, $seconds = 3600)
    {
        self::$sessionRegistry->setUser($this->user);

        if ($remember) {
            // Save session id in cookies
            $sid = session_id();

            $expire = time() + $days * $hours * $seconds;
            $domain = ""; // default domain
            $secure = false;
            $path = "/";

            $cookie = setcookie("PHPSESSID", $sid, $expire, $path, $domain, $secure, $http_only);
        }
    }
}