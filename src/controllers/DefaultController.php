<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function index() {
        $this->render('login');
    }

    public function mainpage() {
        $this->render('mainpage');
    }

    public function profile() {
        $this->render('profile');
    }

    public function competition() {
        $this->render('competition');
    }

    public function results() {
        $this->render('results');
    }

    public function attendee_list() {
        $this->render('attendee-list');
    }

    public function competition_photos() {
        $this->render('competition-photos');
    }

    public function achievements_mobile() {
        $this->render('achievements-mobile');
    }

    public function map_mobile() {
        $this->render('map-mobile');
    }

    public function photos_mobile() {
        $this->render('photos-mobile');
    }

    public function news_mobile() {
        $this->render('news-mobile');
    }

}