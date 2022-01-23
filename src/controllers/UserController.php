<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/ProfilePhotosRepository.php';

class UserController extends AppController {
    private $userRepository;
    private $photosRepository;

    public function __construct() {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->photosRepository = new ProfilePhotosRepository();
    }

    public function profile(array $messages = []) {
        $this->isLogged();

        $user = $this->userRepository->getUser($_COOKIE['userEmail']);

        $messages = array_merge($messages, [
            'name' => $user->getName(),
            'surname' => $user->getSurname(),
            'phone_number' => $user->getPhoneNumber(),
            'birth_date' => $user->getBirthDate(),
            'email' => $user->getEmail(),
            'photos' => $this->photosRepository->getPhotosForProfile()]);

        return $this->render('profile', $messages);
    }

    public function checkIfCanCreate() {
        $canCreate = $this->userRepository->checkIfUserCanCreate($_COOKIE['userEmail']);

        header('Content-type: application/json');
        http_response_code(200);

        echo json_encode($canCreate);
    }
}