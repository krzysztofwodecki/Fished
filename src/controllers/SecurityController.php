<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController {
    private $userRepository;
    private $messages = [];

    public function __construct() {
        parent::__construct();
        $this->userRepository = new UserRepository();
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

        return $this->render('main_page');
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
        $confirm_password = $_POST["confirm_password"];
        $name = $_POST["name"];
        $surname = $_POST["surname"];

        if($this->validateRegister($email, $password, $confirm_password, $name, $surname)) {
            $password = password_hash($password, PASSWORD_DEFAULT);

            $user = new User($email, $password, $name, $surname);
            $this->userRepository->addUser($user);

            return $this->render('login', ['messages' => ['Rejestracja przebiegła poprawnie']]);
        }

        return $this->render('register', ['messages' => $this->messages]);
    }

    private function validateRegister($email, $password, $confirm_password, $name, $surname): bool {
        if($email == null) {
            $this->messages = ['Nieprawidłowy email'];
            return false;
        }

        if($this->userRepository->getUser($email) !== null) {
            $this->messages = ['Użytkownik o podanym emailu już istnieje'];
            return false;
        }

        if($password == null) {
            $this->messages = ['Brak hasła'];
            return false;
        }

        if($confirm_password == null) {
            $this->messages = ['Brak potwierdzenia hasła'];
            return false;
        }

        if($password !== $confirm_password) {
            $this->messages = ['Hasła nie są zgodne'];
            return false;
        }

        if($name == null) {
            $this->messages = ['Uzupełnij imię'];
            return false;
        }

        if($surname == null) {
            $this->messages = ['Uzupełnij nazwisko'];
            return false;
        }

        return true;
    }

}