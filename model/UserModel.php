<?php

class UserModel{
    
    private $username;
    private $password;
    private $message;
    private $usernameRegister;
    private $passwordRegister;
    private $passwordRepeat;
    private $text;
    //private $guestBook;
    
    public function __construct(){
       
    }

    public function setUsername($username){
        $this->username = $username; 
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getMessage() {
        return $this->message;
    }

    public function emtyFields(){
        if($this->username == "" && $this->password == "") {
            $this->message = "Username is missing";
            return true;
        } else {
            return false;
        }
    }

    public function emptyPasswordField() {
        if($this->username == "Admin" && $this->password == "") {
            $this->message = "Password is missing";
            return true;
        } else {
            return false;
        }
    }

    public function emptyUsernameField() {
        if($this->username == "" && $this->password == "Password") {
            $this->message = "Username is missing";
            return true;
        } else {
            return false;
        }
    }

    public function wrongNameOrPassword() {
        if($this->username == "Admin" && $this->password != "Password" || $this->username != "Admin" && $this->password == "Password") {
            $this->message = "Wrong name or password";
            return true;
        } else {
            return false;
        }
    }

    public function correctUsernameAndPassword() {
        if($this->username == "Admin" && $this->password == "Password") {
            $this->message = "Welcome";
            $_SESSION['username'] = $this->username;
            $_SESSION['password'] = $this->password;
            return true;
        } else {
            return false;
        }
    }

    public function userLoggedIn() {
        if(isset($_SESSION['username']) && isset($_SESSION['password'])) {
            session_unset("loggedIn");
            return true;
        } else {
            return false;
        }
    }


    public function ifSetMessageLogIn() {
        if(!isset($_SESSION["loggedIn"])) {
            return $_SESSION["loggedIn"] = "logged in";     
        }
    }

    public function ifSetMessageLogOut() {
        if(!isset($_SESSION["loggedOut"])) {
            return $_SESSION["loggedOut"] = "logged out";
        }
    }

    public function loggOutUser() {
        $this->message = "Bye bye!";
        session_unset("username");
        session_unset("password");
        session_unset("loggedIn");
        return true;
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

    public function getUsernameLength() {
        return strlen($this->usernameRegister);
    }

    public function getPasswordLength() {
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
        if ($this->usernameRegister == "Admin" && $this->getPasswordLength() >= 6 && $this->passwordRegister == $this->passwordRepeat) {
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

    public function setCookieMessage() {
        $this->message = "Welcome and you will be remembered";   
    }

    public function checkSession() {
        if(!isset($_SESSION["username"]) && !isset($_SESSION["password"])) {
            return true;
        } else {
            return false;
        }
    }

    public function setSession() {
        if(!isset($_SESSION["username"]) && !isset($_SESSION["password"])) {
            $_SESSION["username"] = "Admin";
            $_SESSION["password"] = "Password";
            $this->message = "Welcome back with cookie";
        }
    }

    public function setText($text) {
        $this->text = $text;
    }

    private function getTextLength(){
        return strlen($this->text);
    }

    public function checktext() {
        if($this->getTextLength() > 0 && $this->getTextLength() <= 10) {
            echo "a";
            return true;
        } else {
            return false;
        }
    }

    public function writeToFile(){
        $file = "guestBook.txt";
        $guestBook = file_get_contents($file);
        $guestBook .= $this->text;
        file_put_contents($file, $guestBook);
    }
}