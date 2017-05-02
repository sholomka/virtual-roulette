<?php

namespace  Application\Core;

use Application\Core\Classes\CheckBets;

/**
 * Class RouletteBetAnalyzer - фасад для внешней библиотеки
 * @package Application\Controllers
 */
class RouletteBetAnalyzer
{
    /**
     * Минимальное выиграшное число
     */
    const WIN_NUM_MIN = 0;

    /**
     * Максимальное выиграшное число
     */
    const WIN_NUM_MAX = 36;

    /**
     * Инстанс для проверки
     *
     * @var CheckBets
     */
    private $checkInstance;

    /**
     * Ставка
     *
     * @var
     */
    private $bet;

    /**
     * Отвалидированная ставка
     *
     * @var Classes\IsValidResponse
     */
    private $validateBet;

    /**
     * Выигрышное число
     *
     * @var int
     */
    private $winNum;

    /**
     * Выигрышная сумма
     *
     * @var
     */
    private $wonAmount;

    /**
     * ControllerAdmin constructor.
     */
    public function __construct($bet)
    {
        $this->checkInstance = new CheckBets();
        $this->bet = $bet;
        $this->validateBet = $this->getValidateBet();
        $this->winNum = $this->generateWinNum();
    }

    /**
     * @return Classes\IsValidResponse
     */
    public function getValidateBet()
    {
        return $this->checkInstance->IsValid($this->bet);
    }

    /**
     * @return bool
     */
    public function getIsValid()
    {
        return $this->validateBet->getIsValid();
    }

    /**
     * @return int
     */
    public function getBetAmount()
    {
        return $this->validateBet->getBetAmount();
    }

    /**
     * @return string
     */
    public function getResponse()
    {
        return "Is bet valid: " . $this->getIsValid() . " bet amount in cents is: " . $this->getBetAmount();
    }

    /**
     * @return int
     */
    public function generateWinNum()
    {
        return  mt_rand (self::WIN_NUM_MIN, self::WIN_NUM_MAX);
    }

    /**
     * @return int
     */
    public function checkWin()
    {
        return $this->wonAmount = $this->checkInstance->EstimateWin($this->bet, $this->winNum);
    }

    /**
     * @return mixed
     */
    public function getWonAmount()
    {
        return $this->wonAmount;
    }

    /**
     * @return string
     */
    public function estimateWin()
    {
        return "User won: " . $this->getWonAmount() . " cents.";
    }
}

