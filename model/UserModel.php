<?php
//username
class UserModel{
    
    private $username;
    private $password;
    private $message;
    private $usernameRegister;
    private $passwordRegister;
    private $passwordRepeat;
    
    public function __construct(){
       
    }

    public function setUsername($username){
        $this->username = $username; 
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function emtyFields(){
        if($this->username == "" && $this->password == ""){
            $this->message = "Username is missing";
            return true;
        } else {
            return false;
        }
    }

    public function emptyPasswordField(){
        if($this->username == "Admin" && $this->password == ""){
            $this->message = "Password is missing";
            return true;
        } else {
            return false;
        }
    }

    public function wrongNameOrPassword(){
        if($this->username == "Admin" && $this->password != "Password" || $this->username != "Admin" && $this->password == "Password") {
            $this->message = "Wrong name or password";
            return true;
        } else {
            return false;
        }
    }

    public function correctUsernameAndPassword(){
        if($this->username == "Admin" && $this->password == "Password"){
            $this->message = "welcome";
            $_SESSION['username'] = $this->username;
            $_SESSION['password'] = $this->password;
            return true;
        } else {
            return false;
        }
    }

    public function userLoggedIn(){
        if(isset($_SESSION['username']) && isset($_SESSION['password'])){
            return true;
        } else {
            return false;
        }
    }

    public function getMessage(){
        return $this->message;
    }

    public function ifSetMessage(){
        if(!isset($_SESSION["loggedIn"])){
            return $_SESSION["loggedIn"] = "logged in";     
        }
    }

    public function loggOutUser(){
        session_unset("username");
        session_unset("password");
        session_unset("loggedIn");
    }

    public function emtypFieldsRegister(){

    }

    public function setRegisterUsername($usernameRegister){
        $this->usernameRegister = $usernameRegister;
    }

    public function setRegisterPassword($passwordRegister){
        $this->passwordRegister = $passwordRegister;
    }

    public function setPasswordRepeat($passwordRepeat){
        $this->passwordRepeat = $passwordRepeat;
    }

    



    

  


}