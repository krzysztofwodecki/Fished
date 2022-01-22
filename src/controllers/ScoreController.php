<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/ScoreRepository.php';

class ScoreController extends AppController {
    private $scoreRepository;

    public function __construct() {
        parent::__construct();
        $this->scoreRepository = new ScoreRepository();
    }

    public function results() {
        $this->isLogged();

        list($coded, $code) = $this->decodeCompetitionID();
        $scoreList = $this->scoreRepository->getScoreList($code);

//        var_dump($scoreList);

        $messages = ['id' => $coded,'scores' => $scoreList];

        return $this->render('results', $messages);
    }
}