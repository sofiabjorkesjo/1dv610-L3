<?php 

require_once('UserData.php');

class RegisterModel{

    private $message;
    private $usernameRegister;
    private $passwordRegister;
    private $passwordRepeat;
    private $userData;

    public function __construct() {
        $this->userData = new UserData();
    }

    public function getMessage() {
        return $this->message;
    }

    public function setRegisterUsername($usernameRegister) {
        $this->usernameRegister = $usernameRegister;
    }

    public function setRegisterPassword($passwordRegister) {
        $this->passwordRegister = $passwordRegister;
    }

    public function setPasswordRepeat($passwordRepeat) {
        $this->passwordRepeat = $passwordRepeat;
    }

    private function getUsernameLength() {
        return strlen($this->usernameRegister);
    }

    private function getPasswordLength() {
        return strlen($this->passwordRegister);
    }

    public function emtypFieldsRegister() {
        if($this->usernameRegister == "" && $this->passwordRegister == "" && $this->passwordRepeat == "") {
            $this->message = "Username has too few characters, at least 3 characters. <br> Password has too few characters, at least 6 characters.";
            return true;
        } else {
            return false;
        }
    }

    public function emptyPasswordRegister() {
        if($this->getUsernameLength() >= 3 && $this->passwordRegister == "") {
            $this->message =  "Password has too few characters, at least 6 characters.";
            return true;
        } else {
            return false;
        }
    }

    public function shortUsername() {
        if($this->getUsernameLength() < 3 && $this->getPasswordLength() >= 6 && $this->passwordRegister == $this->passwordRepeat) {
            $this->message = "Username has too few characters, at least 3 characters.";
            return true;
        } else {
            return false;
        }
    }

    public function shortPassword() {
        if($this->getUsernameLength() >= 3 && $this->getPasswordLength() < 6 && $this->passwordRegister == $this->passwordRepeat) {
            $this->message =  "Password has too few characters, at least 6 characters.";
            return true;
        } else {
            return false;
        }
    }

    public function notOkPasswordRepeat() {
        if ($this->getUsernameLength() >= 3 && $this->getPasswordLength() >= 6 && $this->passwordRegister != $this->passwordRepeat) {
            $this->message = "Passwords do not match.";
            return true;
        } else {
            return false;
        }
    }

    public function userExist() {
        if ($this->usernameRegister == $this->userData->rightUsername() && $this->getPasswordLength() >= 6 && $this->passwordRegister == $this->passwordRepeat) {
            $this->message = "User exists, pick another username.";
            return true;
        } else {
            return false;
        }
    }

    public function checkForTags() {
        if($this->usernameRegister != strip_tags($this->usernameRegister) && $this->getPasswordLength() >= 6 && $this->passwordRegister == $this->passwordRepeat) {
            $this->message =  "Username contains invalid characters.";
            return true;
        } else {
            return false;
        }
    }
}