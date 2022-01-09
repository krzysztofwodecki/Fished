<?php

class Competition {
    private $name;
    private $date;
    private $gathering_time;
    private $start_time;
    private $code;
    private $on_boat;
    private $sites;
    private $id_place;
    private $remaining_sites;

    public function __construct($name, $date, $gathering_time, $start_time, $on_boat,
                                $sites, $id_place, $remaining_sites, $code = null) {

        $this->name = $name;
        $this->date = $date;
        $this->gathering_time = $gathering_time;
        $this->start_time = $start_time;
        $this->on_boat = $on_boat;
        $this->sites = $sites;
        $this->id_place = $id_place;
        $this->remaining_sites = $remaining_sites;
        $this->code = $code;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function getGatheringTime()
    {
        return $this->gathering_time;
    }

    public function setGatheringTime($gathering_time): void
    {
        $this->gathering_time = $gathering_time;
    }

    public function getStartTime()
    {
        return $this->start_time;
    }

    public function setStartTime($start_time): void
    {
        $this->start_time = $start_time;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code): void
    {
        $this->code = $code;
    }

    public function getOnBoat()
    {
        return $this->on_boat;
    }

    public function setOnBoat($on_boat): void
    {
        $this->on_boat = $on_boat;
    }

    public function getSites()
    {
        return $this->sites;
    }

    public function setSites($sites): void
    {
        $this->sites = $sites;
    }

    public function getIdPlace()
    {
        return $this->id_place;
    }

    public function setIdPlace($id_place): void
    {
        $this->id_place = $id_place;
    }

    public function getRemainingSites()
    {
        return $this->remaining_sites;
    }

    public function setRemainingSites($remaining_sites): void
    {
        $this->remaining_sites = $remaining_sites;
    }


}