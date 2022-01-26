<?php

class Competition {
    private $name;
    private $date;
    private $gathering_time;
    private $start_time;
    private $end_time;
    private $code;
    private $sites;
    private $id_place;
    private $remaining_sites;
    private $fishery;

    public function __construct($name, $date, $gathering_time, $start_time,
                                $end_time, $sites, $id_place) {

        $this->name = $name;
        $this->date = $date;
        $this->gathering_time = $gathering_time;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->sites = $sites;
        $this->id_place = $id_place;
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

    public function getEndTime()
    {
        return $this->end_time;
    }

    public function setEndTime($end_time): void
    {
        $this->end_time = $end_time;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code): void
    {
        $this->code = $code;
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

    public function getFishery()
    {
        return $this->fishery;
    }

    public function setFishery($fishery): void
    {
        $this->fishery = $fishery;
    }
}