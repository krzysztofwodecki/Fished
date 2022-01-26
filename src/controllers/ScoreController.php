<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/ScoreRepository.php';
require_once __DIR__.'/../models/Score.php';

class ScoreController extends AppController {
    private $scoreRepository;
    private $competitionPhotosRepository;
    private $competitionRepository;

    public function __construct() {
        parent::__construct();
        $this->scoreRepository = new ScoreRepository();
        $this->competitionPhotosRepository = new CompetitionPhotosRepository();
        $this->competitionRepository = new CompetitionRepository();
    }

    public function results() {
        if(!$this->isGet()) {
            return $this->render('main_page');
        }

        $code = $this->decodeCompetitionID();
        $scoreList = $this->scoreRepository->getScoreList($code);

        $messages = ['scores' => $scoreList];

        return $this->render('results', $messages);
    }

    public function grade_photo() {
        if(!$this->isPost()) {
            return $this->render('main_page');
        }

        $score = $_POST['score'];
        $argumentation = $_POST['argumentation'];
        $photo = $_POST['photo'];

        $photo = new File($photo);
        $score = new Score($photo, $score, $argumentation);

        $this->scoreRepository->scorePhoto($score);

        $code = $this->decodeCompetitionID();
        $photos = $this->competitionPhotosRepository->getAllCompetitionPhotos($code);
        $isJudge = $this->competitionRepository->isJudge($code);
        $messages = ['photos' => $photos, 'isJudge' => $isJudge];

        header("Location: competition_photos?id=".$_POST['id'], true, 303);

        return $this->render('competition_photos', $messages);
    }

    public function getScoreDetails() {
        $photo = new File($_GET['photo']);
        $score = $this->scoreRepository->getScoreDetails($photo);

        header('Content-type: application/json');
        http_response_code(200);

        echo json_encode($score);
    }
}