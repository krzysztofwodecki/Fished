<?php

require_once __DIR__.'/../../Database.php';

class Repository {
    protected $database;

    //TODO Singleton

    public function __construct()
    {
        $this->database = new Database();
    }
}