<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/MapRepository.php';
require_once __DIR__ . '/../models/Fishery.php';

class MapController extends AppController {
    private $mapRepository;

    public function __construct()
    {
        parent::__construct();
        $this->mapRepository = new MapRepository();

    }

    public function add_fishery() {
        if(!$this->isPost()) {
            return $this->render('main_page');
        }

        $name = $_POST["name"];
        $address = $_POST["address"];
        $town = $_POST["town"];
        $postal = $_POST["postal"];
        $latitude = $_POST["latitude"];
        $longitude = $_POST["longitude"];

        $fishery = new Fishery($name, $address, $town, $postal, $latitude, $longitude);

        $this->mapRepository->addFishery($fishery);

        return $this->render('main_page');
    }

    public function getFisheries() {
        $fisheries = $this->mapRepository->getFisheries();

        header('Content-type: application/json');
        http_response_code(200);

        echo json_encode($fisheries);
    }
}