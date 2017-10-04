<?php
//username
class UserModel{
    
    private $username;
    private $password;
    
    public function __construct(){
   
    }

    public function setUsername($username){
        $this->username = $username;
        echo "set ";
        echo $username;
    }

    public function usernameOk($username){
        if($username == "Admin"){
            $_SESSION['username'] = $username;
           // $_SESSION['password'] = $password;
            //byta vy
            echo "yoyoyo";
            return true;
        } else {
           return false;
        }
    }

    public function succesfullLoggedIn(){
        if($_SESSION['username'] && $_SESSION['password']){
            echo "logged in ";
            return true;
        } else {
            return false;
        }
    }

    public function usernameNotOk(){
        if($this->emptyFields()){
            return true;
        } else {
            return false;
        }
    }

    public function emptyFields(){
        if($this->username == "" && $this->password == ""){
            echo "uuu";
            return true;
        } else {
            return false;
        }
    }


    //kolla alla use case för användarnamnet


}