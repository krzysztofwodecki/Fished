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
        $competition = $this->competitionRepository->getCompetition($code);

        if($competition === null) {
            $messages['message'] = "Niepoprawny kod";

            return $this->render('main_page', $messages);
        }

        if($competition->getRemainingSites($code) == 0) {
            $messages['message'] = "Brak wolnych miejsc na zawodach";

            return $this->render('main_page', $messages);
        }

        $position = $this->getUniquePosition($competition);
        $endTime = date("'Y-m-d H:i:s'",strtotime($competition->getDate().$competition->getEndTime()));

        if($endTime < date("'Y-m-d H:i:s'")) {
            $messages['message'] = "Zawody nieaktualne";

            return $this->render('main_page', $messages);
        }

        if($this->competitionRepository->isContestant($code)) {
            $messages['message'] = "Jesteś już uczestnikiem";

            return $this->render('main_page', $messages);
        }

        if(!$this->competitionRepository->addAttendee($code, $position)) {
            $messages['message'] = "Błąd podczas dodawania uczestnika";

            return $this->render('main_page', $messages);
        }

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

    private function getUniquePosition(Competition $competition) {
        do {
            $position = mt_rand(1, $competition->getSites());
        } while(!$this->competitionRepository->positionUniqueness($position));

        return $position;
    }
}