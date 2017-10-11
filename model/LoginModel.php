<?php

require_once('UserData.php');

class LoginModel {
    
    private $username;
    private $password;
    private $message;
    private $userData;
  
    public function __construct() {
       $this->userData = new UserData();
    }

    public function setUsername($username) {
        $this->username = $username; 
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getMessage() {
        return $this->message;
    }

    public function emtyFields() {
        if($this->username == "" && $this->password == "") {
            $this->message = "Username is missing";
            return true;
        } else {
            return false;
        }
    }

    public function emptyPasswordField() {
        if($this->username == $this->userData->rightUsername() && $this->password == "") {
            $this->message = "Password is missing";
            return true;
        } else {
            return false;
        }
    }

    public function emptyUsernameField() {
        if($this->username == "" && $this->password == $this->userData->rightPassword()) {
            $this->message = "Username is missing";
            return true;
        } else {
            return false;
        }
    }

    public function wrongNameOrPassword() {
        if($this->username == $this->userData->rightUsername() && $this->password != $this->userData->rightPassword() || $this->username != $this->userData->rightUsername() && $this->password == $this->userData->rightPassword()) {
            $this->message = "Wrong name or password";
            return true;
        } else {
            return false;
        }
    }

    public function correctUsernameAndPassword() {
        if($this->username == $this->userData->rightUsername() && $this->password == $this->userData->rightPassword()) {
            if ($this->userLoggedIn() == false) {
                $this->message = "Welcome";
            } else {
                $this->message = "";
            }
            $_SESSION['username'] = $this->username;
            $_SESSION['password'] = $this->password;
            return true;
        } else {
            return false;
        }
    }

    public function userLoggedIn() {
        if(isset($_SESSION['username']) && isset($_SESSION['password'])) {
            return true;
        } else {
            return false;
        }
    }

    public function loggOutUser() {
        if ($this->userLoggedIn()) {
            $this->message = "Bye bye!";
        } else {
            $this->message = "";
        }
        session_unset("username");
        session_unset("password");
        session_unset("loggedIn");
        return true;
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
            $_SESSION["username"] = $this->userData->rightUsername();
            $_SESSION["password"] = $this->userData->rightPassword();
            $this->message = "Welcome back with cookie";
        }
    }
}