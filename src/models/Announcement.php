<?php

class Announcement {
    private $title;
    private $content;
    private $cover_photo;
    private $attachment;
    private $date;

    public function __construct($title, $content, $cover_photo = null, $attachment = null)
    {
        $this->title = $title;
        $this->content = $content;
        $this->cover_photo = $cover_photo;
        $this->attachment = $attachment;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content): void
    {
        $this->content = $content;
    }

    public function getCoverPhoto()
    {
        return $this->cover_photo;
    }

    public function setCoverPhoto($cover_photo): void
    {
        $this->cover_photo = $cover_photo;
    }

    public function getAttachment()
    {
        return $this->attachment;
    }

    public function setAttachment($attachment): void
    {
        $this->attachment = $attachment;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date): void
    {
        $this->date = $date;
    }
}