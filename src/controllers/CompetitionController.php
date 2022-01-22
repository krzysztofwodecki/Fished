<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Competition.php';
require_once __DIR__.'/../repository/CompetitionRepository.php';

class CompetitionController extends AppController {
    private $competitionRepository;

    public function __construct() {

        parent::__construct();
        $this->competitionRepository = new CompetitionRepository();
    }

    public function competition() {
        if(!$this->isGet()) {
            $messages = ['competitions' => $this->competitionRepository->getCompetitions()];

            if(!$this->isPost()) {
                return $this->render('main_page', $messages);
            }
        }

        // TODO validate user

        list($coded, $code) = $this->decodeCompetitionID();

        $messages = ['id' => $coded, 'competition' => $this->competitionRepository->getCompetition($code)];

        return $this->render('competition', $messages);
    }

    public function add_competition() {
        $messages = ['competitions' => $this->competitionRepository->getCompetitions()];

        if(!$this->isPost()) {
            return $this->render('main_page', $messages);
        }

        $name = $_POST['name'];
        $date = $_POST['date'];
        $gathering_time = $_POST['gathering_time'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $sites = $_POST['sites'];
        $id_place = $_POST['fishery'];

        //TODO competition end_time

        $competition = new Competition($name, $date, $gathering_time, $start_time,
            $end_time, $sites, $id_place);

        $competition->setRemainingSites(intval($sites) - 1);
        $this->createCode($competition);

        $this->competitionRepository->addCompetition($competition);
        $this->competitionRepository->addAttendee($competition->getCode());

        $messages = ['competitions' => $this->competitionRepository->getCompetitions()];

        return $this->render('main_page', $messages);
    }

    public function main_page() {
        $this->isLogged();

        $messages = ['competitions' => $this->competitionRepository->getCompetitions()];

        return $this->render('main_page', $messages);

    }

    private function createCode(Competition $competition): void {
        $code = '';

        do {
            $string = str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789");

            for($i = 0; $i < 6; $i++) {
                $code .= $string[mt_rand(0, strlen($string) - 1)];
            }
        } while (!$this->competitionRepository->codeUnique($code));

        $competition->setCode($code);
    }
}