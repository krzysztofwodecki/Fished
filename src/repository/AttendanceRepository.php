<?php

require_once 'Repository.php';

class AttendanceRepository extends Repository {

    public function getAttendeeList(string $code) {
        $stmt = $this->database->connect()->prepare('
            SELECT ua.name as "name", surname, email, position, resource_name
            FROM attendance a
            INNER JOIN competitions c on c.id_competitions = a.id_competition
            INNER JOIN user_account ua on a.id_user = ua.id_user_account
            LEFT JOIN resources r on ua.id_profile_photo = r.id_resources
            WHERE code = :code
        ');

        $stmt->bindParam(':code', $code);
        $stmt->execute();

        $attendeeArray = $stmt->fetchAll();

        $attendee = [];

        if($attendeeArray !== false) {
            foreach ($attendeeArray as $element) {
                if($element !== null && $element['name'] !== '') {

                    $user = new User($element['name'], $element['surname'], $element['email']);
                    $user->setPosition($element['position']);

                    if(isset($element['resource_name']) && $element['resource_name'] !== null) {
                        $profile_photo = new File($element['resource_name']);
                        $user->setProfilePhoto($profile_photo);
                    }

                    $attendee[] = $user;
                }
            }
        }

        return $attendee;
    }

    public function getAttendeePosition($code) {
        $stmt = $this->database->connect()->prepare('
            SELECT position FROM attendance a
            INNER JOIN competitions c on c.id_competitions = a.id_competition
            INNER JOIN user_account ua on a.id_user = ua.id_user_account
            WHERE code = ? and email = ?
        ');

        $stmt->execute([
           $code,
           $_COOKIE['userEmail']
        ]);

        $position = $stmt->fetch(PDO::FETCH_ASSOC);

        return $position['position'];
    }
}