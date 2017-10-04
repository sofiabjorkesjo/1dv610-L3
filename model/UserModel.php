<?php
//username
class UserModel{
    
    private $username;
    private $password;
    private $message;
    
    public function __construct(){
        if($this->checkLogIn()){
            echo "checked";
        }
    }

    public function setUsername($username){
        $this->username = $username; 
        return $username;
    }

    public function setPassword($password){
        $this->password = $password;
        return $password;
    }

    public function emtyFields(){
        if($this->username == "" && $this->password == ""){
            echo "empty";
            return true;
        } else {
            return false;
        }
    }

    public function correctUsernameAndPassword(){
        if($this->username == "Admin" && $this->password == "Password"){
            echo "yyaaaaay ";
            $_SESSION['username'] = $this->username;
            $_SESSION['password'] = $this->password;
            return true;
        } else {
            return false;
        }
    }

    public function checkLogIn(){
        if ($this->correctUsernameAndPassword()){
            //set message
            echo "yo";
            $this->userLoggedIn();
        } else if ($this->emtyFields()){
            echo "oo";
            //set message;
        }
    }

    public function userLoggedIn(){
        if($_SESSION['username']){
            echo " wowo ";
            return true;
        } else {
            return false;
        }
    }

    //kollar alla värden
    //funktion för om de är OK = inloggad
    //funktion för om ej ok = ej inloggad



    

  


}