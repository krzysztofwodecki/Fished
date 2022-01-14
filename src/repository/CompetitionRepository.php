<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Competition.php';

class CompetitionRepository extends Repository {

    public function getCompetition(int $id): ?Competition {

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.competitions WHERE id_competitions = :id
        ');

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $competition = $stmt->fetch(PDO::FETCH_ASSOC);

        if($competition == false) {
            return null;
        }

        return new Competition (
            $competition['name'],
            $competition['date'],
            $competition['gathering_time'],
            $competition['start_time'],
            $competition['on_boat'],
            $competition['sites'],
            $competition['id_place'],
            $competition['remaining_sites'],
            $competition['code']
            //TODO delete remaining sites, since when it will be calculated on spot
        );
    }


    public function addCompetition(Competition $competition): void {
        $this->createCode($competition);

        $stmt = $this->database->connect()->prepare('
            INSERT INTO competitions (name, date, gathering_time, start_time, 
                                      code, on_boat, sites, id_place, remaining_sites)
            VALUES (?,?,?,?,?)
        ');

        $stmt->execute([
            $competition->getName(),
            $competition->getDate(),
            $competition->getGatheringTime(),
            $competition->getStartTime(),
            $competition->getCode(),
            $competition->getOnBoat(),
            $competition->getSites(),
            $competition->getIdPlace(),
            $competition->getRemainingSites()
        ]);
    }

    private function createCode(Competition $competition): void {
        $code = '';

        do {
            $string = str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789");

            for($i = 0; $i < 6; $i++) {
                $code .= $string[mt_rand(0, strlen($string) - 1)];
            }
        } while (!$this->codeUniqueness($code));

        $competition->setCode($code);
    }

    private function codeUniqueness($code): bool {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.competitions WHERE code = :code
        ');

        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->execute();

        $competition = $stmt->fetch(PDO::FETCH_ASSOC);

        if($competition == false) {
            return false;
        } else return true;
    }
}