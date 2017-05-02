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
}

