<?php

class Score {
    private $name;
    private $surname;
    private $score;

    public function __construct($name, $surname, $score)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->score = $score;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function setScore($score)
    {
        $this->score = $score;
    }


}