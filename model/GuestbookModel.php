<?php

class GuestbookModel {
    
    private $text;
    private $message;

    public function __construct() {

    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getMessage() {
        return $this->message;
    }

    public function sendToController() {
        return $this->text;
    }

    public function messageNotLoggedIn() {
        $this->message = "You need to be logged in to add a text to the guest book!";
    }

    public function checkText() {
        if($this->getTextLength() >= 1 && $this->getTextLength() <= 20) {
            $this->message = "The text is saved in the guest book!";
            return true;
        } else {
            $this->message = "Text must be 1-20 characters.";
            return false;
        }
    }

    public function writeToFile($textToFile) {
        $file = "guestBook.txt";
        $guestBook = file_get_contents($file);
        $guestBook .= $textToFile;
        file_put_contents($file, $guestBook);
    }

    private function getTextLength() {
        return strlen($this->text);
    }
}