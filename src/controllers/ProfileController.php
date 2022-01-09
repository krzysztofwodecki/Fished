<?php

class ProfileController extends AppController {
    private $userRepository;

    public function __construct() {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function profile(){
        $user = $this->userRepository->getUser($_COOKIE['userEmail']);

        return $this->render('profile', ['name' => $user->getName(), 'surname' => $user->getSurname(),
            'phone_number' => $user->getPhoneNumber(), 'email' => $user->getEmail()]);
    }
}