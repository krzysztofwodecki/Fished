<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function index() {
        $this->render('login');
    }

    public function achievements_mobile() {
        $this->render('achievements-mobile');
    }

    public function map_mobile() {
        $this->render('mapMainPage-mobile');
    }

    public function photos_mobile() {
        $this->render('photos-mobile');
    }

    public function news_mobile() {
        $this->render('news-mobile');
    }

    public function registerPage() {
        $this->render('register');
    }

}