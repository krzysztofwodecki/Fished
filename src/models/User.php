<?php

class User {
    private $email;
    private $password;
    private $name;
    private $surname;
    private $birth_date;
    private $phone_number;
    private $id;
    private $profile_photo;
    private $position;

    public function __construct(string $name, string $surname, string $email, string $password = null) {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->surname = $surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname)
    {
        $this->surname = $surname;
    }

    public function getBirthDate()
    {
        return $this->birth_date;
    }

    public function setBirthDate($birth_date): void
    {
        $this->birth_date = $birth_date;
    }

    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    public function setPhoneNumber($phone_number): void
    {
        $this->phone_number = $phone_number;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getProfilePhoto() {
        return $this->profile_photo;
    }

    public function setProfilePhoto($profile_photo): void
    {
        $this->profile_photo = $profile_photo;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function setPosition(string $position): void
    {
        $this->position = $position;
    }


}