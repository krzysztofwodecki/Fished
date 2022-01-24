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

        //TODO make it a sql view

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

        // TODO order by date

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

    public function addAttendee($code): bool {
        $pdo = $this->database->connect();

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare('
            INSERT INTO attendance(id_user, id_competition)
            VALUES ((SELECT id_user_account FROM user_account WHERE email = ?),
                    (SELECT id_competitions FROM competitions WHERE code = ?))
        ');

            $stmt->execute([
                $_COOKIE['userEmail'],
                $code
            ]);

            $stmt = $pdo->prepare('
            UPDATE competitions c SET remaining_sites = 
                (SELECT comp.remaining_sites FROM competitions comp WHERE comp.code = :code) - 1 
                WHERE c.code = :code
        ');

            $stmt->bindParam(':code', $code);
            $stmt->execute();

            $pdo->commit();

            //TODO check on update cascade

            return true;

        } catch (PDOException $e) {
            $pdo->rollBack();

            return false;
        }
    }


    public function getRemainingSites($code) {
        //TODO
        return 200;
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
}