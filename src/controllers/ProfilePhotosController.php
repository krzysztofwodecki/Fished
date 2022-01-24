<?php

require_once 'FileController.php';
require_once 'UserController.php';
require_once __DIR__."/../repository/ProfilePhotosRepository.php";

class ProfilePhotosController extends FileController {
    private $profileController;
    private $profilePhotosRepository;

    public function __construct() {
        parent::__construct();
        $this->profileController = new UserController();
        $this->profilePhotosRepository = new ProfilePhotosRepository();
    }

    public function addPhotoOnProfile(){
        if($this->isPost()) {
            $file = $this->addFile('file');
            $this->profilePhotosRepository->addPhotoOnProfile($file);
        }

        $this->profileController->profile();
    }

    public function deletePhotoOnProfile() {
        $this->deletePhoto();
        $this->profileController->profile();
    }
}