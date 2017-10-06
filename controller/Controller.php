<?php 

//skapa vyer och modeller
//fråga vyn om man postat
//vyn svarar ja eller nej
//om nej, händer inget
//om ja, fråga modellen om reglerna stämmer
//svarar ja eller nej
//om ja visa en annan vy
//om nej, kasta felmeddelande / exception

require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');
require_once('model/UserModel.php');

class Controller{

    private $layoutView;
    private $dateTimeView;
    private $loginView;
    private $registerView;
    private $userModel;
    private $test;
    private $body;
    private $link;

    public function __construct(){
        $this->layoutView = new LayoutView();
        $this->dateTimeView = new DateTimeView(); 
        $this->loginView = new LoginView();
        $this->userModel = new UserModel();
        $this->registerView = new RegisterView();
       
    }

    public function showView(){
       $this->body = $this->setBody();
       $this->link = $this->showLink();
       if($this->body == $this->loginView->generateLogoutButtonHTML()){
            $this->layoutView->render(true, $this->loginView, $this->body, $this->link, $this->dateTimeView);
       } else {
            $this->layoutView->render(false, $this->loginView, $this->body, $this->dateTimeView);
       }            
       $this->logIn();
    }

    public function showLink(){ 
        if($this->loginView->clickRegisterLink()){
            //Sätt länknamnet här
        }
    }

    public function setBody(){     
        $this->body = $this->loginView->generateLoginFormHTML();
        if($this->logIn()){
            //FIXA PÅ ANNAT SÄTT??
            if($this->userModel->ifSetMessage()){
                $message = $this->userModel->getMessage();
                $this->loginView->setMessage($message);
            }      
            $this->body = $this->loginView->generateLogoutButtonHTML();
        } else if ($this->userModel->userLoggedIn()){ 
            $this->body = $this->loginView->generateLogoutButtonHTML();
        } else if($this->logIn() == false) {
            $message = $this->userModel->getMessage();
            $this->loginView->setMessage($message);
            $this->body = $this->loginView->generateLoginFormHTML();
        } 
        if($this->logOut()){
            $this->body = $this->loginView->generateLoginFormHTML();
        }
        if($this->loginView->clickRegisterLink()){
            $this->body = $this->registerView->generateRegisterForm();

        }  
        return $this->body;
    }

    public function logIn(){
        if($this->loginView->submitForm()){
            $username = $this->loginView->getUsername();
            $password = $this->loginView->getPassword();   
            $this->userModel->setUsername($username); 
            $this->userModel->setPassword($password);

            if($this->userModel->correctUsernameAndPassword()){
                return true;  
            } else if($this->notCorrectLogIn()){
                return false;
            }   
               
        } 
    }

    public function notCorrectLogIn(){
        if($this->userModel->emtyFields() || $this->userModel->emptyPasswordField() || $this->userModel->wrongNameOrPassword()){
            return true;
        } else {
            return false;
        }
    }

    public function logOut(){
        if($this->loginView->clickLogOut()){
            $this->userModel->loggOutUser();
            return true;
        } else {
            return false;
        }
    }

    public function register(){
        if($this->registerView->clickRegister()){
            $usernameRegister = $this->registerView->getUsernameRegister();
            $passwordRegister = $this->registerView->getPasswordRegister();
            $passwordRepeat = $this->registerView->getPasswordRepeat();
            $this->registerView->setUsernameRegister($username);
            $this->registerView->setPasswordRegister($passwordRegister);
            $this->registerView->setPasswordRepeat($passwordRepeat);
            //fortsätt här
        }
    }

    

   


   

    



   

    


}