<?php

require_once 'FileController.php';
require_once __DIR__.'/../models/Announcement.php';
require_once __DIR__.'/../repository/AnnouncementRepository.php';

class AnnouncementController extends FileController {
    private $announcementRepository;
    private $competitionRepository;

    public function __construct() {
        parent::__construct();
        $this->announcementRepository = new AnnouncementRepository();
        $this->competitionRepository = new CompetitionRepository();
    }

    public function add_announcement() {
        if(!$this->isPost()){
            return $this->render('competition');
        }

        $announcement = new Announcement($_POST['title'], $_POST['content']);

        if(isset($_FILES['cover-photo']) && $_FILES['cover-photo']['name'] !== '') {
            $coverPhoto = $this->addFile('cover-photo');
            $announcement->setCoverPhoto($coverPhoto);
        }

        if(isset($_FILES['attachment']) && $_FILES['attachment']['name'] !== '') {
            $attachment = $this->addFile('attachment');
            $announcement->setAttachment($attachment);
        }

        $code = $this->decodeCompetitionID();
        $this->announcementRepository->addAnnouncement($code, $announcement);

        $isCreator = $this->competitionRepository->isCreator($code);
        $announcements = $this->announcementRepository->getAnnouncements($code);

        $messages = ['competition' => $this->competitionRepository->getCompetition($code),
            'creator' => $isCreator, 'announcements' => $announcements];

        header("Location: competition?id=".$_POST['id'], true, 303);

        return $this->render('competition', $messages);
    }

    public function getAnnouncementDetails() {
        $name = $_GET['announcementTitle'];
        $date = $_GET['announcementDate'];

        $announcement = $this->announcementRepository->getAnnouncement($name, $date);

        header('Content-type: application/json');
        http_response_code(200);

        echo json_encode($announcement);
    }

    public function news_mobile() {
        if(!$this->isGet()) {
            $messages = ['competitions' => $this->competitionRepository->getCompetitions()];

            return $this->render('main_page', $messages);
        }

        $code = $this->decodeCompetitionID();

        $messages = ['announcements' => $this->announcementRepository->getAnnouncements($code)];

        return $this->render('news_mobile', $messages);
    }
}