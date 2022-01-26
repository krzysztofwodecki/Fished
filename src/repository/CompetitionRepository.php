<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Competition.php';
require_once __DIR__.'/../models/User.php';

class CompetitionRepository extends Repository {

    public function getCompetitions($user = null) {
        $stmt = $this->database->connect()->prepare('
            SELECT *, c.name as "comp_name", f.name as "fishery_name" FROM public.competitions c
            FULL JOIN attendance a ON a.id_competition = c.id_competitions
            FULL JOIN user_account ua ON ua.id_user_account = a.id_user
            FULL JOIN fisheries f on c.id_place = f.id_fisheries
            WHERE ua.email = :email ORDER BY c.date;
        ');

        if($user === null) {
            $stmt->bindParam(':email', $_COOKIE['userEmail']);
        } else {
            $email = $user->getEmail();
            $stmt->bindParam(':email', $email);
        }


        $stmt->execute();

        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $competitions = [];

        if($array != false) {
            foreach ($array as $element) {
                if($element['comp_name'] !== null) {
                    $competition = $this->createCompetitionInstance($element);
                    array_push($competitions, $competition);
                }
            }
        }

        return $competitions;
    }

    public function getCompetition($code): ?Competition {
        $stmt = $this->database->connect()->prepare('
            SELECT *, c.name as "comp_name", f.name as "fishery_name" FROM public.competitions c
            FULL JOIN attendance a ON a.id_competition = c.id_competitions
            FULL JOIN fisheries f on c.id_place = f.id_fisheries
            WHERE c.code = :code
        ');

        $stmt->bindParam(':code', $code);
        $stmt->execute();

        $element = $stmt->fetch(PDO::FETCH_ASSOC);

        if($element) {
            if($element['comp_name'] !== null) {
                return $this->createCompetitionInstance($element);
            }
        }

        return null;
    }

    public function addCompetition(Competition $competition): void {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO competitions (name, date, gathering_time, start_time, end_time,
                                      code, id_place, sites, remaining_sites, creator)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 
                    (SELECT ua.id_user_account FROM user_account ua WHERE email = ?))
        ');

        $stmt->execute([
            $competition->getName(),
            $competition->getDate(),
            $competition->getGatheringTime(),
            $competition->getStartTime(),
            $competition->getEndTime(),
            $competition->getCode(),
            $competition->getIdPlace(),
            $competition->getSites(),
            $competition->getRemainingSites(),
            $_COOKIE['userEmail']
        ]);
    }

    public function codeUnique($code): bool {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.competitions WHERE code = :code
        ');

        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->execute();

        $competition = $stmt->fetch(PDO::FETCH_ASSOC);

        if($competition == false) {
            return true;
        } else return false;
    }

    public function addAttendee($code, $position): bool {
        $pdo = $this->database->connect();

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare('
            INSERT INTO attendance(id_user, id_competition, position)
            VALUES ((SELECT id_user_account FROM user_account WHERE email = ?),
                    (SELECT id_competitions FROM competitions WHERE code = ?), ?)
        ');

            $stmt->execute([
                $_COOKIE['userEmail'],
                $code,
                $position
            ]);

            $stmt = $pdo->prepare('
            UPDATE competitions c SET remaining_sites = 
                (SELECT comp.remaining_sites FROM competitions comp WHERE comp.code = :code) - 1 
                WHERE c.code = :code
        ');

            $stmt->bindParam(':code', $code);
            $stmt->execute();

            $pdo->commit();

            return true;

        } catch (PDOException $e) {
            $pdo->rollBack();

            return false;
        }
    }

    public function getRemainingSites($code) {
        $stmt = $this->database->connect()->prepare('
            SELECT remaining_sites FROM competitions
            WHERE code = ?
        ');

        $stmt->execute([
            $code
        ]);

        $remaining_sites = $stmt->fetch(PDO::FETCH_ASSOC);

        return $remaining_sites['remaining_sites'];
    }

    private function createCompetitionInstance($element): Competition {
        $fishery = new Fishery (
            $element['fishery_name'],
            $element['address'],
            $element['town'],
            $element['postal'],
            $element['latitude'],
            $element['longitude']
        );

        $competition = new Competition (
            $element['comp_name'],
            $element['date'],
            $element['gathering_time'],
            $element['start_time'],
            $element['end_time'],
            $element['sites'],
            $element['id_place']
        );

        $competition->setRemainingSites($element['remaining_sites']);
        $competition->setCode($element['code']);
        $competition->setFishery($fishery);

        return $competition;
    }

    public function isCreator($code): bool {
        $stmt = $this->database->connect()->prepare('
            SELECT ua.name FROM competitions c 
            INNER JOIN user_account ua on c.creator = ua.id_user_account
            WHERE c.code = :code AND ua.email = :email
        ');

        $stmt->bindParam(":code", $code);
        $stmt->bindParam(":email", $_COOKIE['userEmail']);

        $stmt->execute();
        $array = $stmt->fetch(PDO::FETCH_ASSOC);

        if($array == false) {
            return false;
        }

        return true;
    }

    public function isJudge($code) {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM competitions c 
            INNER JOIN attendance a on a.id_competition = c.id_competitions
            INNER JOIN user_account ua on a.id_user = ua.id_user_account
            WHERE c.code = :code AND ua.email = :email AND a.judge IS true
        ');

        $stmt->bindParam(":code", $code);
        $stmt->bindParam(":email", $_COOKIE['userEmail']);

        $stmt->execute();
        $array = $stmt->fetch(PDO::FETCH_ASSOC);

        if($array == false) {
            return false;
        }

        return true;

    }

    public function positionUniqueness($position) {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM attendance
            WHERE position = ?
        ');

        $stmt->execute([
            $position
        ]);

        if($stmt->fetch(PDO::FETCH_ASSOC) == false) {
            return true;
        } else return true;
    }

    public function isContestant($code) {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM attendance
            INNER JOIN user_account ua on attendance.id_user = ua.id_user_account
            INNER JOIN competitions c on attendance.id_competition = c.id_competitions
            WHERE code = ? and email = ?
        ');

        $stmt->execute([
            $code,
            $_COOKIE['userEmail']
        ]);

        if($stmt->fetch(PDO::FETCH_ASSOC)) {
            return true;
        } else return false;

    }
}