<?php

class File {
    private $name;
    private $date;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

}