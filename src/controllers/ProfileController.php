<?php

class ProfileController extends AppController {
    private $userRepository;
    private $resourceRepository;

    public function __construct() {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->resourceRepository = new ResourceRepository();
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
            'photos' => $this->resourceRepository->getResource(ResourceDestination::ON_PROFILE)]);

        return $this->render('profile', $messages);
    }
}