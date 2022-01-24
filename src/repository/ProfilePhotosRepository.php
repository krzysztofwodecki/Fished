<?php

require_once 'FileRepository.php';

class ProfilePhotosRepository extends FileRepository {

    public function addPhotoOnProfile($file) {
        $stmt = $this->database->connect()->prepare('
            WITH IDENTITY AS (INSERT INTO resources(resource_name, date) 
            VALUES (?,?) RETURNING id_resources)
            INSERT INTO resources_on_profile(id_profile, id_resource) 
            VALUES ((SELECT id_user_account FROM public.user_account WHERE email = ?), 
            (SELECT id_resources FROM IDENTITY))
        ');

        $stmt->execute([
            $file->getName(),
            date("Y.m.d"),
            $_COOKIE['userEmail']
        ]);
    }

    public function getPhotosForProfile($email): array {
        $stmt = $this->database->connect()->prepare('
            SELECT resource_name FROM resources r
            FULL JOIN resources_on_profile rp ON r.id_resources=rp.id_resource
            FULL JOIN user_account ua ON rp.id_profile = ua.id_user_account
            WHERE email = :email
        ');

        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $res_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $resources = [];

        if($res_array != false) {
            foreach ($res_array as $resource) {
                if($resource['resource_name'] !== null) {
                    array_push($resources, new File($resource['resource_name']));
                }
            }
        }

        return $resources;
    }

    public function addProfilePhoto(File $profilePhoto) {
        $stmt = $this->database->connect()->prepare('
            WITH IDENTITY AS (INSERT INTO resources(resource_name, date) 
            VALUES (?,?) RETURNING id_resources)
            UPDATE user_account
            SET id_profile_photo = (SELECT id_resources FROM IDENTITY)
            WHERE email = ? 
        ');

        $stmt->execute([
            $profilePhoto->getName(),
            date("Y.m.d"),
            $_COOKIE['userEmail']
        ]);
    }
}