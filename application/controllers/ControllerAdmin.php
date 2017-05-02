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


    public function isBetValid($bet)
    {
        //Create Instance
        $checkInstance = new CheckBets();

        //Check Valid
        $validateBet = $checkInstance->IsValid($bet);
        $isValid = $validateBet->getIsValid();
        $betAmount = $validateBet->getBetAmount();

        return [
            'isValid' => $isValid,
            'betAmount' => $betAmount
        ];
    }

    public function actionMakeBet()
    {
        if ($this->request->isPost()) {
            $bet = json_encode([[
                'T' => $this->request->getProperty('T'),
                'I' => $this->request->getProperty('I'),
                'C' => $this->request->getProperty('C'),
                'K' => $this->request->getProperty('K')
            ]]);

            $rouletteBetAnalyzer = new RouletteBetAnalyzer($bet);
            $message = [];

            if ($rouletteBetAnalyzer->getIsValid()) {
                if ($this->model->amountSave()) {
                    $message[] = $rouletteBetAnalyzer->getResponse();

                    if ($rouletteBetAnalyzer->checkWin()) {
                        $wonAmount = $rouletteBetAnalyzer->getWonAmount();

                        if ($this->model->wonAmountSave($wonAmount)) {
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
}

