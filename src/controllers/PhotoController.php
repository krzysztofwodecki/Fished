<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Photo.php';

class PhotoController extends AppController {
    const MAX_FILE_SIZE = 1024*1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/photos_on_profile/';

    private $message = [];

    public function addPhoto() {

        if($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['file']['name']
            );

            $photo = new Photo($_FILES['file']['name']);

            $this->render('profile', ['messages' => $this->message , 'photo' => $photo]);
        }

        $this->render('profile', ['messages' => $this->message]);
    }

    private function validate(array $file):bool {
        if($file['size'] > self::MAX_FILE_SIZE) {
            $this->message[] = 'Plik jest za duży.';
            return false;
        }

        if(!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->message[] = 'Nieprawidłowy format pliku.';
            return false;
        }

        return true;
    }
}