<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Resource.php';
require_once __DIR__.'/../models/ResourceDestination.php';

class ResourceRepository extends Repository {

    public function addResource(Resource $res, ResourceDestination $dest) {
        if($dest === ResourceDestination::ON_PROFILE){
            $this->addOnProfile($res);
        }

        if($dest === ResourceDestination::PROFILE_PHOTO){
            $this->addProfilePhoto($res);
        }

        if($dest === ResourceDestination::COMPETITION_PHOTO){
            $this->addCompetitionPhoto($res);
        }

        if($dest === ResourceDestination::NEWS_COVER_PHOTO){
            $this->addNewsCoverPhoto($res);
        }

        if($dest === ResourceDestination::NEWS_ATTACHMENT){
            $this->addNewsAttachment($res);
        }
    }

    public function getResource(ResourceDestination $dest){
        if($dest === ResourceDestination::ON_PROFILE){
            return $this->getOnProfile();
        }
    }

    private function addOnProfile(Resource $res) {
        $stmt = $this->database->connect()->prepare('
            WITH IDENTITY AS (INSERT INTO resources(resource_name, date) 
            VALUES (?,?) RETURNING id_resources)
            INSERT INTO resources_on_profile(id_profile, id_resource) 
            VALUES ((SELECT id_user_account FROM public.user_account WHERE email = ?), 
            (SELECT id_resources FROM IDENTITY))
        ');

        $stmt->execute([
            $res->getName(),
            date("d.m.Y"),
            $_COOKIE['userEmail']
        ]);
    }

    private function getOnProfile(): array {
        $stmt = $this->database->connect()->prepare('
            SELECT resource_name FROM resources r
            FULL JOIN resources_on_profile rp ON r.id_resources=rp.id_resource
            FULL JOIN user_account ua ON rp.id_profile = ua.id_user_account
            WHERE email = :email
        ');

        $stmt->bindParam(':email', $_COOKIE['userEmail'], PDO::PARAM_STR);
        $stmt->execute();

        $res_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $resources = [];

        if($res_array != false) {
            foreach ($res_array as $resource) {
                if($resource['resource_name'] !== null) {
                    array_push($resources, new Resource($resource['resource_name']));
                }
            }
        }

        return $resources;
    }

    private function addProfilePhoto(Resource $res) {
        //TODO
    }

    private function addCompetitionPhoto(Resource $res) {
        //TODO
    }

    private function addNewsCoverPhoto(Resource $res) {
        //TODO
    }

    private function addNewsAttachment($res) {
        //TODO
    }
}