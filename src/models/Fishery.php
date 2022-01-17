<?php

class Fishery {
    private $name;
    private $address;
    private $town;
    private $postal;
    private $latitude;
    private $longitude;

    public function __construct($name, $address, $town, $postal, $latitude, $longitude)
    {
        $this->name = $name;
        $this->address = $address;
        $this->town = $town;
        $this->postal = $postal;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address): void
    {
        $this->address = $address;
    }

    public function getTown()
    {
        return $this->town;
    }

    public function setTown($town): void
    {
        $this->town = $town;
    }

    public function getPostal()
    {
        return $this->postal;
    }

    public function setPostal($postal): void
    {
        $this->postal = $postal;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude): void
    {
        $this->latitude = $latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude): void
    {
        $this->longitude = $longitude;
    }

}