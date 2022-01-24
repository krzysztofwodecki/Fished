<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Competition.php';
require_once __DIR__.'/../repository/CompetitionRepository.php';

class CompetitionController extends AppController {
    private $competitionRepository;
    private $announcementRepository;

    public function __construct() {

        parent::__construct();
        $this->competitionRepository = new CompetitionRepository();
        $this->announcementRepository = new AnnouncementRepository();
    }

    public function competition() {
        if(!$this->isGet()) {
            $messages = ['competitions' => $this->competitionRepository->getCompetitions()];

            return $this->render('main_page', $messages);
        }

        // TODO validate user

        $code = $this->decodeCompetitionID();
        $isCreator = $this->competitionRepository->isCreator($code);

        $messages = ['creator' => $isCreator,
            'competition' => $this->competitionRepository->getCompetition($code),
            'announcements' => $this->announcementRepository->getAnnouncements($code)];

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

        $competition->setRemainingSites($sites);
        $this->createCode($competition);

        $this->competitionRepository->addCompetition($competition);

        if(!$this->competitionRepository->addAttendee($competition->getCode())) {
            $messages = ['messages' => "Napotkano błąd przy dodawaniu uczestnika",
                'competitions' => $this->competitionRepository->getCompetitions()];

            return $this->render('main_page', $messages);
        }

        $messages = ['competitions' => $this->competitionRepository->getCompetitions()];

        return $this->render('main_page', $messages);
    }

    public function join_competition() {
        $messages = ['competitions' => $this->competitionRepository->getCompetitions()];

        if(!$this->isPost()) {
            return $this->render('main_page', $messages);
        }

        $code = $_POST['code'];

        if($this->competitionRepository->getCompetition($code) === null) {
            array_push($messages, ['message' => "Niepoprawny kod"]);

            return $this->render('main_page', $messages);
        }

        if($this->competitionRepository->getRemainingSites($code) == 0) {
            array_push($messages, ['message' => "Brak wolnych miejsc na zawodach"]);

            return $this->render('main_page', $messages);
        }

        if(!$this->competitionRepository->addAttendee($code)) {
            array_push($messages, ['message' => "Błąd podczas dodawania uczestnika"]);

            return $this->render('main_page', $messages);
        }

        //TODO already contestant, old competition

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