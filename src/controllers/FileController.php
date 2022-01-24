<?php

require_once 'AppController.php';
require_once 'UserController.php';
require_once __DIR__ . '/../models/File.php';
require_once __DIR__ . '/../repository/FileRepository.php';

class FileController extends AppController {
    const MAX_FILE_SIZE = 2048*2048;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg', 'image/gif'];
    const SUPPORTED_TYPES_ATTACHMENT = ['image/png', 'image/jpeg', 'image/gif',
        'application/pdf', 'application/zip',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';

    private $resourceRepository;
    private $message;
    //TODO return message


    public function __construct() {
        parent::__construct();
        $this->resourceRepository = new FileRepository();
    }

    protected function addFile($name): ?File {
        $current_time = microtime(true);

        if($this->isPost() && is_uploaded_file($_FILES[$name]['tmp_name']) && $this->validate($name)) {
            move_uploaded_file(
                $_FILES[$name]['tmp_name'],
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$current_time.$_FILES[$name]['name']
            );

            return new File($current_time.$_FILES[$name]['name']);
        }

        return null;
    }

    private function validate($name):bool {
        $file = $_FILES[$name];

        if($file['size'] > self::MAX_FILE_SIZE) {
            $this->message[] = 'Plik jest za duży.';
            return false;
        }

        if(!isset($file['type']) || !in_array($file['type'],
                $name === 'attachment' ? self::SUPPORTED_TYPES_ATTACHMENT : self::SUPPORTED_TYPES)) {
            $this->message[] = 'Nieprawidłowy format pliku.';
            return false;
        }

        return true;
    }

    protected function deletePhoto() {
        if(isset($_GET['selectedPhoto']) && $_GET['selectedPhoto'] !== null) {
            if($this->resourceRepository->deleteFile($_GET['selectedPhoto'])){
                unlink(dirname(__DIR__).self::UPLOAD_DIRECTORY.$_GET['selectedPhoto']);
            }
        }
    }
}