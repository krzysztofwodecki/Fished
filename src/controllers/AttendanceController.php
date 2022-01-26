<?php

require_once __DIR__."/../repository/AttendanceRepository.php";
require_once "AppController.php";

class AttendanceController extends AppController {
    private $attendanceRepository;

    public function __construct() {
        parent::__construct();
        $this->attendanceRepository = new AttendanceRepository();
    }


    public function attendee_list() {
        if(!$this->isGet()) {
            $this->render('main_page');
        }

        $code = $this->decodeCompetitionID();

        $attendee = $this->attendanceRepository->getAttendeeList($code);
        $messages['attendee'] = $attendee;

        $this->render('attendee_list', $messages);
    }
}