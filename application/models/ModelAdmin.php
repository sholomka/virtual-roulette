<?php

namespace  Application\Models;

use Application\Core\Model;


/**
 * Class ModelAdmin
 * @package Application\Models
 */
class ModelAdmin extends Model
{
    /**
     * Запрос на вывод всеё истории
     *
     * @var string
     */
    public static $getHistory = "SELECT 
                                   spinID,
                                   betAmount, 
                                   wonAmount, 
                                   dateAdd
                                 FROM bets
                                 WHERE userID = :userID";
                               

    /**
     * Запрос на обновление суммы ставки
     *
     * @var string
     */
    public static $amountSave = "INSERT INTO bets 
                                 SET 
                                    betAmount = :betAmount,   
                                    number = :number,
                                    userID = :userID
                                ";

    /**
     * Запрос на обновление выиграшной суммы
     *
     * @var string
     */
    public static $wonAmountSave = "UPDATE bets 
                                    SET 
                                       wonAmount = :wonAmount
                                    WHERE 
                                        spinID = :spinID 
                                    AND userID = :userID";

    /**
     * Оюновляет баланса пользователя
     *
     * @var string
     */
    public static $updateUserBalance = "UPDATE users 
                                        SET 
                                           userbalance = userbalance + :userbalance
                                        WHERE 
                                           id = :id";


    /**
     * Получает баланс пользователя
     *
     * @var string
     */
    public static $getUserBalance = "SELECT 
                                      userbalance 
                                     FROM users 
                                     WHERE id = :id";


    /**
     * Сохраняет сумму и номер ставки
     */
    public function updateUserBalance($userbalance)
    {
        $id= static::$sessionRegistry->getUserId();

        $this->doStatement(self::$updateUserBalance,  [
            ':userbalance' => $userbalance,
            ':id' => $id
        ]);
    }

    /**
     * Получает баланса пользователя
     *
     * @return mixed
     */
    public function getUserBalance()
    {
        $id = static::$sessionRegistry->getUserId();

        $stmt = $this->doStatement(self::$getUserBalance, [
            ':id' => $id
        ]);

        if ($result = $stmt->fetch(\PDO::FETCH_OBJ)) {
            return $result;
        }
    }

    /**
     * Сохраняет сумму и номер ставки
     */
    public function amountSave()
    {
        $betAmount = $this->request->getProperty('K');
        $number = $this->request->getProperty('I');
        $userID = static::$sessionRegistry->getUserId();

        return (bool) $this->doStatement(self::$amountSave,  [
            ':betAmount' => $betAmount,
            ':number' => $number,
            ':userID' => $userID
        ]);
    }

    /**
     * Сохраняет сумму и номер ставки
     *
     * @param $wonAmount
     * @return bool
     */
    public function wonAmountSave($wonAmount)
    {
        $userID = static::$sessionRegistry->getUserId();
        $spinID =  $this->id;

        return (bool) $this->doStatement(self::$wonAmountSave, [
            ':wonAmount' => $wonAmount,
            ':userID' => $userID,
            ':spinID' => $spinID
        ]);
    }

    /**
     * Возвращает всю историю ставок
     *
     * @return array
     */
    public function getGameHistory()
    {
        $userID = static::$sessionRegistry->getUserId();
        $stmt = $this->doStatement(self::$getHistory, [
            ':userID' => $userID
        ]);

        if ($result = $stmt->fetchAll(\PDO::FETCH_OBJ)) {
            return $result;
        }
    }
}

