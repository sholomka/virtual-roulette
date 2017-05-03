<?php

namespace  Application\Controllers;

use Application\Core\Controller;
use Application\Models\ModelAdmin;
use Application\Core\User;
use Application\Core\RouletteBetAnalyzer;

/**
 * Class ControllerAdmin
 * @package Application\Controllers
 */
class ControllerAdmin extends Controller
{
    /**
     * ControllerAdmin constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new ModelAdmin();
    }

    /**
     * Action по умолчанию
     */
    public function actionIndex()
    {
        $this->view->generate('admin_view.php', 'template_view.php');
    }

    /**
     * Action разлогина пользователя
     */
    public function actionLogout()
    {
        User::logout();
    }

    /**
     * Делает ставку
     */
    public function actionMakeBet()
    {
        if ($this->request->isPost()) {
            $betCount = $this->request->getProperty('K');

            $bet = json_encode([[
                'T' => $this->request->getProperty('T'),
                'I' => $this->request->getProperty('I'),
                'C' => $this->request->getProperty('C'),
                'K' => $betCount
            ]]);

            $rouletteBetAnalyzer = new RouletteBetAnalyzer($bet);
            $message = [];

            if ($rouletteBetAnalyzer->getIsValid()) {
                if ($this->model->amountSave()) {
                    $this->model->updateUserBalance(-$betCount);
                    $this->setJackpotAmount($betCount);

                    $message[] = $rouletteBetAnalyzer->getResponse();

                    if ($rouletteBetAnalyzer->checkWin()) {
                        $wonAmount = $rouletteBetAnalyzer->getWonAmount();

                        if ($this->model->wonAmountSave($wonAmount)) {
                            $this->model->updateUserBalance($wonAmount);
                            $message[] = $rouletteBetAnalyzer->estimateWin();
                        }
                    }

                    echo json_encode(['message' => implode(' ', $message)]);
                }
            }

           exit;
        }

        $this->view->generate('makebet_view.php', 'template_view.php');
    }

    /**
     * Получает историю игры
     */
    public function actionGetGameHistory()
    {
        $data = $this->model->getGameHistory();
        $this->view->generate('gamehistory_view.php', 'template_view.php', $data);
    }

    /**
     * Получает баланс пользователя
     */
    public function actionGetUserBalance()
    {
        $data = $this->model->getUserBalance();
        echo json_encode(['message' => $data->userbalance]);
        exit;
    }

    /**
     * Показывает текущий Jackpot Amount
     */
    public function actionGetJackpotAmount()
    {
        $applicationRegistry = $this->applicationRegistry;
        $memcache = $applicationRegistry::getMemcache();

        echo $memcache->get('JackpotAmount');
    }

    /**
     * Устанавливет JackpotAmount
     *
     * @param $betAmount
     */
    public function setJackpotAmount($betAmount)
    {
        $onePercent = 1 * 100 / $betAmount;
        $applicationRegistry = $this->applicationRegistry;
        $memcache = $applicationRegistry::getMemcache();
        $jackpotAmount = 0;

        try {
            $jackpotAmount = $memcache->get('JackpotAmount');
        } catch(\Exception $e) {
        }

        $jackpotAmountNew = $jackpotAmount + $onePercent;
        $memcache->set('JackpotAmount', $jackpotAmountNew);
    }
}

