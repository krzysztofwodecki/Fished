<?php

require_once 'Repository.php';

class MapRepository extends Repository {

    public function getFisheries(): array {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM fisheries;
        ');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addFishery(Fishery $fishery) {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO fisheries(name, address, town, postal, latitude, longitude)
            VALUES (?, ?, ?, ?, ?, ?)
        ');

        $stmt->execute([
            $fishery->getName(),
            $fishery->getAddress(),
            $fishery->getTown(),
            $fishery->getPostal(),
            $fishery->getLatitude(),
            $fishery->getLongitude()
        ]);
    }


}