<?php

require_once 'FileController.php';
require_once 'ProfileController.php';
require_once __DIR__."/../repository/UserRepository.php";

class ProfilePhotosController extends FileController {
    private $profileController;

    public function __construct() {
        parent::__construct();
        $this->profileController = new ProfileController();
    }

    public function addPhotoOnProfile(){
        $file = $this->addFile();
        $this->profileController->profile();
    }

    public function deletePhotoOnProfile() {
        $this->deletePhoto();
        $this->profileController->profile();
    }
}