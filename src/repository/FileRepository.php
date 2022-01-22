<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/File.php';
require_once __DIR__.'/../models/ResourceDestination.php';

class FileRepository extends Repository {

    protected function addFile($file) {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO resources(resource_name, date) 
            VALUES (?,?) RETURNING id_resources as "id"
        ');

        $stmt->execute([
            $file->getName(),
            date("Y.m.d")]);

        $array = $stmt->fetch(PDO::FETCH_ASSOC);

        return $array['id'];
    }

    public function deleteFile($name): bool {
        $stmt = $this->database->connect()->prepare('
            DELETE from resources
            WHERE resource_name = :resource_name
        ');

        $stmt->bindParam(':resource_name', $name, PDO::PARAM_STR);

        return $stmt->execute();
    }
}