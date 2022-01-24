<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../models/File.php';

class UserRepository extends Repository {

    public function getUser(string $email): ?User {

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM user_account ua
            INNER JOIN credentials c ON c.id_user = ua.id_user_account 
            LEFT JOIN resources r ON r.id_resources = ua.id_profile_photo
            WHERE email = :email 
        ');

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $userArray = $stmt->fetch(PDO::FETCH_ASSOC);

        if($userArray == false) {
            return null;
        }

        $user = new User($userArray['email'], $userArray['hash'], $userArray['name'], $userArray['surname']);

        if($userArray['phone'] !== null) {
            $user->setPhoneNumber($userArray['phone']);
        }

        if($userArray['birth_date'] !== null) {
            $user->setBirthDate($userArray['birth_date']);
        }

        if(isset($userArray['resource_name']) && $userArray['resource_name'] !== null) {
            $profilePhoto = new File($userArray['resource_name']);
            $user->setProfilePhoto($profilePhoto);
        }

        return $user;
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
            date("Y.m.d")
        ]);
    }

    public function revoked($email): bool {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.user_account ua
            INNER JOIN public.credentials c ON ua.id_user_account = c.id_user
            INNER JOIN public.revocations r ON r.id_credential = c.id_credentials
            WHERE email = :email
        ');

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $revocation = $stmt->fetch(PDO::FETCH_ASSOC);

        if($revocation == false) {
            return false;
        }

        return true;
    }

    public function checkIfUserCanCreate($email): bool {
        $stmt = $this->database->connect()->prepare('
            SELECT can_add_competitions FROM public.user_account ua
            WHERE email = :email
        ');

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $canCreate = $stmt->fetch(PDO::FETCH_ASSOC);

        return $canCreate['can_add_competitions'];
    }

    public function alterUser(User $user) {
        $pdo = $this->database->connect();

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare('
                UPDATE user_account
                SET name = ?, surname = ?, birth_date = ?, phone = ?, email = ?
                WHERE email = ?
            ');

            $stmt->execute([
                $user->getName(),
                $user->getSurname(),
                $user->getBirthDate(),
                $user->getPhoneNumber(),
                $user->getEmail(),
                $_COOKIE['userEmail']
            ]);

            $stmt = $pdo->prepare('
                UPDATE credentials
                SET hash = ?
                WHERE id_user = (SELECT id_user_account FROM user_account WHERE email = ?)
            ');

            $stmt->execute([
                $user->getPassword(),
                $user->getEmail()
            ]);

            $pdo->commit();

            return true;

        } catch (PDOException $e) {
            $pdo->rollBack();

            return false;
        }


    }

}