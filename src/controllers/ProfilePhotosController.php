<?php

require_once 'FileController.php';
require_once 'UserController.php';
require_once __DIR__."/../repository/ProfilePhotosRepository.php";

class ProfilePhotosController extends FileController {
    private $profileController;
    private $profilePhotosRepository;
    private $message;

    public function __construct() {
        parent::__construct();
        $this->profileController = new UserController();
        $this->profilePhotosRepository = new ProfilePhotosRepository();
    }

    public function addPhotoOnProfile(){
        if($this->isPost()) {
            $file = $this->addFile('file');

            if(!gettype($file) == 'string') {
                $this->profilePhotosRepository->addPhotoOnProfile($file);
            } else $this->message = $file;
        }

        $this->profileController->profile($this->message);
    }

    public function deletePhotoOnProfile() {
        if(isset($_GET['selectedPhoto']) && $_GET['selectedPhoto'] !== null) {
            $this->deletePhoto($_GET['selectedPhoto']);
        }
        $this->profileController->profile();
    }
}