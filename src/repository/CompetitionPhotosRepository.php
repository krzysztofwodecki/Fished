<?php

class CompetitionPhotosRepository extends FileRepository {

    public function addCompetitionPhoto($file, $code) {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO score(id_photo, id_attendance) 
            VALUES (?, (SELECT id_attendance FROM attendance a, user_account ua, competitions c
                        WHERE a.id_user = ua.id_user_account
                        AND a.id_competition = c.id_competitions
                        AND ua.email = ?
                        AND c.code = ?))
        ');

        $stmt->execute([
            $this->addFile($file),
            $_COOKIE['userEmail'],
            $code
        ]);
    }

    public function getCompetitionPhotos($code) {
        $stmt = $this->database->connect()->prepare('
            SELECT resource_name as "name" FROM resources r
            FULL JOIN score s ON r.id_resources = s.id_photo
            FULL JOIN attendance a ON a.id_attendance = s.id_attendance
            FULL JOIN user_account ua on ua.id_user_account = a.id_user
            FULL JOIN competitions c on a.id_competition = c.id_competitions
            WHERE ua.email = :email 
            AND c.code = :code  
        ');

        $stmt->bindParam(':email', $_COOKIE['userEmail']);
        $stmt->bindParam(':code', $code);
        $stmt->execute();

        $photos_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $photos = [];

        if($photos_array != false) {
            foreach ($photos_array as $photo) {
                if($photo['name'] !== null) {
                    array_push($photos, new File($photo['name']));
                }
            }
        }

        return $photos;
    }
}