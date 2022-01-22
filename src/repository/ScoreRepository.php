<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Score.php';

class ScoreRepository extends Repository {

    public function getScoreList(string $code) {
        $stmt = $this->database->connect()->prepare('
            SELECT ua.name, ua.surname, sum(s.score) as "score"
            FROM attendance a
            LEFT JOIN score s ON s.id_attendance = a.id_attendance
            INNER JOIN user_account ua ON a.id_user = ua.id_user_account
            INNER JOIN competitions c on a.id_competition = c.id_competitions
            WHERE c.code = :code
            GROUP BY (ua.email, ua.name, ua.surname, s.score)
            ORDER BY s.score
        ');

        $stmt->bindParam(':code', $code);
        $stmt->execute();

        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $scores = [];

        if($array != false) {
            foreach ($array as $element) {
                if($element['name'] !== null) {
                    $score = new Score($element['name'],
                        $element['surname'],
                        $element['score'] == null ? 0 : $element['score']);
                    array_push($scores, $score);
                }
            }
        }

        return $scores;
    }
}