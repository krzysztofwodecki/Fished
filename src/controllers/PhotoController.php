<?php

require_once 'AppController.php';
require_once 'ProfileController.php';
require_once __DIR__ . '/../models/Resource.php';
require_once __DIR__.'/../repository/ResourceRepository.php';

class PhotoController extends AppController {
    const MAX_FILE_SIZE = 1024*1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';

    private $message = [];
    private $resourceRepository;

    public function __construct() {
        parent::__construct();
        $this->resourceRepository = new ResourceRepository();
    }

    public function addPhotoOnProfile(){
        $this->addPhoto(ResourceDestination::ON_PROFILE);
    }

    public function addProfilePhoto(){
        $this->addPhoto(ResourceDestination::PROFILE_PHOTO);
    }

    public function addNewsAttachment(){
        $this->addPhoto(ResourceDestination::NEWS_ATTACHMENT);
    }

    public function addNewsCoverPhoto(){
        $this->addPhoto(ResourceDestination::NEWS_COVER_PHOTO);
    }

    public function addCompetitionPhoto(){
        $this->addPhoto(ResourceDestination::COMPETITION_PHOTO);
    }

    private function addPhoto(ResourceDestination $dest) {
        $current_time = microtime(true);

        if($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$current_time.$_FILES['file']['name']
            );

            $photo = new Resource($current_time.$_FILES['file']['name']);
            $this->resourceRepository->addResource($photo, $dest);
        }

        $profileController = new ProfileController();
        $profileController->profile();
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