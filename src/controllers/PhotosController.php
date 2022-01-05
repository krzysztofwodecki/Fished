<?php

require_once 'AppController.php';

class PhotosController extends AppController {
    const MAX_FILE_SIZE = 1024*1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '../public/uploads/';

    private $message = [];

    public function addPhoto(string $destination) {
        if($this->isPost() && is_uploaded_file($_FILES['files']['tmp_name']) && $this->validate($_FILES['files'])) {
            move_uploaded_file(
                $_FILES['files']['tmp_name'],
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['file']['name']
            );

            //TODO saving photos with destination
            $photo = new Photo($destination, $_FILES['file']['name']);

            return $this->render('projects', ['messages' => $this->message]);
        }

        return $this->render('projects', ['messages' => $this->message]);
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