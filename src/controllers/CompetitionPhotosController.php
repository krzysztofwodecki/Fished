<?php

require_once 'FileController.php';
require_once __DIR__."/../repository/CompetitionPhotosRepository.php";

class CompetitionPhotosController extends FileController {
    private $competitionPhotosRepository;
    private $messages;

    public function __construct() {
        parent::__construct();
        $this->competitionPhotosRepository = new CompetitionPhotosRepository();

        $code = $this->decodeCompetitionID();
        $this->messages = ['photos' => $this->competitionPhotosRepository->getCompetitionPhotos($code)];
    }

    public function addCompetitionPhoto(){
        if(!$this->isPost()) {
            return $this->render('competition_photos', $this->messages);
        }

        $code = $this->decodeCompetitionID();
        $photo = $this->addFile('file');

        //TODO invalid photo

        $this->competitionPhotosRepository->addCompetitionPhoto($photo, $code);

        $code = $this->decodeCompetitionID();
        $messages = ['photos' => $this->competitionPhotosRepository->getCompetitionPhotos($code)];

        return $this->render('competition_photos', $messages);
    }

    public function competition_photos() {
        if(!$this->isGet()) {

        }

        $code = $this->decodeCompetitionID();

        $messages = ['photos' => $this->competitionPhotosRepository->getCompetitionPhotos($code)];
        return $this->render('competition_photos', $messages);
    }
}