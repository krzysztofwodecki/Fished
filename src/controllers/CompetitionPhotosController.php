<?php

require_once 'FileController.php';
require_once __DIR__."/../repository/CompetitionPhotosRepository.php";
require_once __DIR__."/../repository/CompetitionRepository.php";

class CompetitionPhotosController extends FileController {
    private $competitionPhotosRepository;
    private $competitionRepository;
    private $messages;
    private $code;

    public function __construct() {
        parent::__construct();
        $this->competitionPhotosRepository = new CompetitionPhotosRepository();
        $this->competitionRepository = new CompetitionRepository();

        $this->code = $this->decodeCompetitionID();
        $this->messages = ['photos' => $this->competitionPhotosRepository->getCompetitionPhotos($this->code)];
    }

    public function addCompetitionPhoto(){
        if(!$this->isPost()) {
            return $this->render('competition_photos', $this->messages);
        }

        $photo = $this->addFile('file');

        if(gettype($photo) !== 'string') {
            $this->competitionPhotosRepository->addCompetitionPhoto($photo, $this->code);
        } else {
            $messages['message'] = $photo;
        }

        $messages['photos'] = $this->competitionPhotosRepository->getCompetitionPhotos($this->code);

        return $this->render('competition_photos', $messages);
    }

    public function competition_photos() {
        if(!$this->isGet()) {
            return $this->render('main_page');
        }

        $isJudge = $this->competitionRepository->isJudge($this->code);
        $competition = $this->competitionRepository->getCompetition($this->code);

        $startTime = date('Y-m-d H:i:s', strtotime($competition->getDate().$competition->getStartTime()));
        $endTime = date('Y-m-d H:i:s', strtotime($competition->getDate().$competition->getEndTime()));
//        $currentTime = date('Y-m-d H:i:s', strtotime("2022-05-05 10:00"));
        $currentTime = date('Y-m-d H:i:s');

        $takesPlace = $startTime <= $currentTime && $currentTime <= $endTime;

        $photos = $isJudge ? $this->competitionPhotosRepository->getAllCompetitionPhotos($this->code) :
            $this->competitionPhotosRepository->getCompetitionPhotos($this->code);

        $messages = ['photos' => $photos,
            'isJudge' => $isJudge,
            'takesPlace' => $takesPlace];

        return $this->render('competition_photos', $messages);
    }
}