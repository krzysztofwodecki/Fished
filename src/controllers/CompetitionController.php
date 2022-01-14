<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Competition.php';
require_once __DIR__.'/../repository/CompetitionRepository.php';

class CompetitionController extends AppController {

    public function add_competition() {
        return $this->render('main_page');
    }

    // TODO
}