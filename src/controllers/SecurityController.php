<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';

class SecurityController extends AppController {

    public function login() {
        $user = new User('mail@gmail.com', 'admin', 'Pussy', "Cat");

        $email = $_POST["email"];
        $password = $_POST["password"];

        if($user->getEmail() !== $email) {
            return $this->render('login', ['message' => 'Wrong email!']);
        }

        if($user->getPassword() !== $password) {
            return $this->render('login', ['message' => 'Wrong password!']);
        }

        return $this->render('mainpage');
    }
}