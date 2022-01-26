<?php

class Score {
    private $photo;
    private $score;
    private $argumentation;

    public function __construct($photo, $score, $argumentation)
    {
        $this->photo = $photo;
        $this->score = $score;
        $this->argumentation = $argumentation;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): void
    {
        $this->photo = $photo;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function setScore($score): void
    {
        $this->score = $score;
    }

    public function getArgumentation()
    {
        return $this->argumentation;
    }

    public function setArgumentation($argumentation): void
    {
        $this->argumentation = $argumentation;
    }


}