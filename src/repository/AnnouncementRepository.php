<?php

require_once 'FileRepository.php';
require_once __DIR__.'/../models/Announcement.php';

class AnnouncementRepository extends FileRepository {
    private $coverPhotoId = null;
    private $attachmentId = null;

    public function addAnnouncement($code, $announcement) {
        if($announcement->getCoverPhoto() !== null) {
            $this->coverPhotoId = $this->addFile($announcement->getCoverPhoto());
        }

        if($announcement->getAttachment() !== null) {
            $this->attachmentId = $this->addFile($announcement->getAttachment());
        }

        $stmt = $this->database->connect()->prepare('
            INSERT INTO announcements(id_photo, title, content, date, id_attachment, id_competition)
            VALUES (?, ?, ?, ?, ?, (SELECT id_competitions FROM competitions WHERE code = ?))
        ');

        $stmt->execute([
            $this->coverPhotoId,
            $announcement->getTitle(),
            $announcement->getContent(),
            date("Y-m-d G:i"),
            $this->attachmentId,
            $code
        ]);
    }

    public function getAnnouncements($code) {
        $stmt = $this->database->connect()->prepare('
            SELECT title, content, pp.resource_name as "photo", att.resource_name as "att", a.date
            FROM announcements a
            LEFT JOIN resources pp ON  pp.id_resources = a.id_photo
            LEFT JOIN resources att ON att.id_resources = a.id_attachment
            INNER JOIN competitions c ON c.id_competitions = a.id_competition
            WHERE code = :code
        ');

        $stmt->bindParam(':code', $code);
        $stmt->execute();

        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $announcements = [];

        if($array !== false) {
            foreach($array as $element) {
                if($element !== null && $element['title'] !== '') {
                    $announcement = new Announcement($element['title'],
                        $element['content'],
                        new File($element['photo']),
                        new File($element['att']));
                    $announcement->setDate($element['date']);
                    $announcements[] = $announcement;
                }
            }
        }

        return $announcements;
    }

    public function getAnnouncement($name, $date) {
        $stmt = $this->database->connect()->prepare('
            SELECT content, pp.resource_name as "photo", att.resource_name as "att"
            FROM announcements a
            LEFT JOIN resources pp ON  pp.id_resources = a.id_photo
            LEFT JOIN resources att ON att.id_resources = a.id_attachment
            WHERE a.title = ? and a.date = ?
        ');

        $stmt->execute([
            $name,
            date("Y-m-d G:i", strtotime($date))
        ]);

        $announcement = $stmt->fetch();

        return ['details' => $announcement['content'],
            'photo' => $announcement['photo'],
            'att' => $announcement['att']];
    }
}