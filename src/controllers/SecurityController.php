<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/CompetitionRepository.php';

class SecurityController extends AppController {
    private $userRepository;
    private $competitionRepository;

    public function __construct() {

        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->competitionRepository = new CompetitionRepository();
    }

    public function login() {
        if(!$this->isPost()) {
            $this->render('login');
        }

        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = $this->userRepository->getUser($email);

        if(!$user) {
            return $this->render('login', ['messages' => ['Podany użytkownik nie istnieje']]);
        }

        if(!password_verify($password, $user->getPassword())) {
            return $this->render('login', ['messages' => ['Nieprawidłowe hasło']]);
        }

        if(!isset($_COOKIE['userEmail'])) {
            setcookie('userEmail', $user->getEmail(), time() + (86400 * 30), "/");
        }

        $messages = ['competitions' => $this->competitionRepository->getCompetitions()];

        return $this->render('main_page', $messages);
    }

    public function logout() {
        if(isset($_COOKIE['userEmail'])) {
            setcookie("userEmail", "mail", time() - 3600, "/");
        }

        return $this->render('login', ['messages' => ['Poprawnie wylogowano']]);
    }

    public function register() {
        if (!$this->isPost()) {
            $this->render('register');
        }

        $email = $_POST["email"];
        $password = $_POST["password"];
        $name = $_POST["name"];
        $surname = $_POST["surname"];

        if($this->userRepository->getUser($email) === null) {
            $password = password_hash($password, PASSWORD_DEFAULT);

            $user = new User($email, $password, $name, $surname);
            $this->userRepository->addUser($user);

            return $this->render('login', ['messages' => ['Rejestracja przebiegła poprawnie']]);
        }

        return $this->render('register', ['messages' => ['Użytkownik o podanym emailu już istnieje']]);
    }
}