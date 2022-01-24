<?php

require_once 'FileController.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/ProfilePhotosRepository.php';

class UserController extends FileController {
    private $userRepository;
    private $photosRepository;
    private $messages = [];

    public function __construct() {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->photosRepository = new ProfilePhotosRepository();
    }

    public function profile(array $messages = []) {
        $this->isLogged();

        $user = $this->userRepository->getUser($_COOKIE['userEmail']);

        $messages = array_merge($messages,
            ['user' => $user, 'photos' => $this->photosRepository->getPhotosForProfile($_COOKIE['userEmail'])]);

        return $this->render('profile', $messages);
    }

    public function edit_profile() {
        if(!$this->isPost()) {
            $this->messages = ['photos' => $this->photosRepository->getPhotosForProfile($_COOKIE['userEmail']),
                'user' => $this->userRepository->getUser($_COOKIE['userEmail'])];

            return $this->render('profile', $this->messages);
        }

        if(isset($_FILES['file']) && $_FILES['file']['name'] !== '') {
            $profilePhoto = $this->addFile();
            $this->photosRepository->addProfilePhoto($profilePhoto);
        }

        $user = $this->userRepository->getUser($_COOKIE['userEmail']);

        if(isset($_POST['name']) && $_POST['name'] !== "") {
            $user->setName($_POST['name']);
        }

        if(isset($_POST['surname']) && $_POST['surname'] !== "") {
            $user->setSurname($_POST['surname']);
        }

        if(isset($_POST['birth_date']) && $_POST['birth_date'] !== "") {
            $user->setBirthDate($_POST['birth_date']);
        }

        if(isset($_POST['phone_number']) && $_POST['phone_number'] !== "") {
            $user->setPhoneNumber($_POST['phone_number']);
        }

        if(isset($_POST['password']) && $_POST['password'] !== "") {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $user->setPassword($password);
        }

        if(isset($_POST['email']) && $_POST['email'] !== "") {
            $user->setEmail($_POST['email']);
        }

        if(!$this->userRepository->alterUser($user)) {
            array_push($this->messages, ['messages' => 'Nie można było dokonać zmian']);
        } else {
            if(isset($_COOKIE['userEmail'])) {
                setcookie('userEmail', $user->getEmail(), time() + (86400 * 30), "/");
            }
        }

        $email = $_POST['email'] == "" ? $_COOKIE['userEmail'] : $_POST['email'];

        $user = $this->userRepository->getUser($email);
        $photos = $this->photosRepository->getPhotosForProfile($email);

        $this->messages['user'] = $user;
        $this->messages['photos'] = $photos;

        return $this->render('profile', $this->messages);
    }

    public function checkIfCanCreate() {
        $canCreate = $this->userRepository->checkIfUserCanCreate($_COOKIE['userEmail']);

        header('Content-type: application/json');
        http_response_code(200);

        echo json_encode($canCreate);
    }
}