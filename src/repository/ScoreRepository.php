<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Result.php';

class ScoreRepository extends Repository {

    public function getScoreList(string $code) {
        $stmt = $this->database->connect()->prepare('
            SELECT ua.name, ua.surname, sum(s.score) as "score"
            FROM attendance a
            INNER JOIN score s ON s.id_attendance = a.id_attendance
            INNER JOIN user_account ua ON a.id_user = ua.id_user_account
            INNER JOIN competitions c on a.id_competition = c.id_competitions
            WHERE c.code = :code and score is not null
            GROUP BY (ua.email, ua.name, ua.surname, s.score)
            ORDER BY s.score DESC
        ');

        $stmt->bindParam(':code', $code);
        $stmt->execute();
        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->database->connect()->prepare('
            SELECT ua.name, ua.surname, 0 as "score"
            FROM attendance a
            INNER JOIN user_account ua ON a.id_user = ua.id_user_account
            INNER JOIN competitions c on a.id_competition = c.id_competitions
            WHERE c.code = :code and not exists (SELECT * from score s where s.id_attendance = a.id_attendance)
            GROUP BY (ua.email, ua.name, ua.surname)
        ');

        $stmt->bindParam(':code', $code);
        $stmt->execute();
        $array = array_merge($array, $stmt->fetchAll(PDO::FETCH_ASSOC));
        $scores = [];

        if($array != false) {
            foreach ($array as $element) {
                if($element['name'] !== null) {
                    $score = new Result($element['name'],
                        $element['surname'],
                        $element['score'] == null ? 0 : $element['score']);
                    array_push($scores, $score);
                }
            }
        }

        return $scores;
    }

    public function scorePhoto($score) {
        $pdo = $this->database->connect();

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare('
            UPDATE score s
            SET score = ?, argumentation = ?
            WHERE s.id_photo = (SELECT r.id_resources FROM resources r WHERE r.resource_name = ?)
            ');

            $stmt->execute([
                $score->getScore(),
                $score->getArgumentation(),
                $score->getPhoto()->getName()
            ]);

            $pdo->commit();

            return true;

        } catch (PDOException $e) {
            $pdo->rollBack();

            return false;
        }
    }

    public function getScoreDetails($photo) {
        $stmt = $this->database->connect()->prepare('
            SELECT score, argumentation FROM score s 
            INNER JOIN resources r on s.id_photo = r.id_resources
            WHERE r.resource_name = ?
        ');

        $stmt->execute([
           $photo->getName()
        ]);

        $score = $stmt->fetch(PDO::FETCH_ASSOC);

        return ['score' => $score['score'], 'argumentation' => $score['argumentation']];
    }
}