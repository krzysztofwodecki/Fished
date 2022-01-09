<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository {

    public function getUser(string $email): ?User {

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.user_account ua, public.credentials c 
            WHERE email = :email and c.id_user = ua.id_user_account
        ');

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user == false) {
            return null;
        }

        return new User(
            $user['email'], $user['hash'], $user['name'], $user['surname']
        );
    }

    public function addUser(User $user) {
        $stmt = $this->database->connect()->prepare('
            WITH IDENTITY AS (INSERT INTO user_account(email, name, surname) 
            VALUES (?,?,?) RETURNING id_user_account)
            INSERT INTO credentials (id_user, hash, date) 
            VALUES ((SELECT id_user_account FROM IDENTITY), ?, ?)
        ');

        $stmt->execute([
            $user->getEmail(),
            $user->getName(),
            $user->getSurname(),
            $user->getPassword(),
            date("d.m.Y")
        ]);
    }

}