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
       if($this->body == $this->loginView->generateLogoutButtonHTML()){
            $this->layoutView->render(true, $this->loginView, $this->body, $this->link, $this->dateTimeView);
       } else {
            $this->layoutView->render(false, $this->loginView, $this->body, $this->link,  $this->dateTimeView);
       }
       //$this->setUsernameAndPassword();            
       //$this->logIn();
    }

    public function setBody(){  
        $this->link = $this->loginView->showLinkRegister();   
        $this->body = $this->loginView->generateLoginFormHTML();
        if($this->logInCookie()){
            $this->userModel->setCookieMessage();
            $message = $this->userModel->getMessage();
            $this->loginView->setMessage($message);

            $this->body = $this->loginView->generateLogoutButtonHTML();
        } else if($this->logIn()){
            //FIXA PÅ ANNAT SÄTT?
            if($this->userModel->ifSetMessageLogIn()){
                $message = $this->userModel->getMessage();
                $this->loginView->setMessage($message);
            }      
            $this->body = $this->loginView->generateLogoutButtonHTML();
        } else if ($this->userModel->userLoggedIn()){ 
            $this->body = $this->loginView->generateLogoutButtonHTML();
        } else if($this->logIn() == false) {
            $message = $this->userModel->getMessage();
            $this->loginView->setMessage($message);
            $this->link = $this->loginView->showLinkRegister(); 
            $this->body = $this->loginView->generateLoginFormHTML();
        } 
        if($this->logOut()){
            //FIXA PÅ ANNAT SÄTT?
            if($this->userModel->ifSetMessageLogOut()){
                var_dump($_SESSION);
                echo "8383838";
                $message = $this->userModel->getMessage();
                $this->loginView->setMessage($message);
            }   
            $this->link = $this->loginView->showLinkRegister(); 
            $this->body = $this->loginView->generateLoginFormHTML();
        }
        if($this->loginView->clickRegisterLink()){
            if($this->register() == false){
                $message = $this->userModel->getMessage();
                $this->registerView->setMessageRegister($message);
            }
            $this->link = $this->registerView->showLinkBack();
            $this->body = $this->registerView->generateRegisterForm();
        }  
        return $this->body;
    }

    public function link(){
        if($this->loginView->showLink() == true){

        }
    }

    public function setUsernameAndPassword(){
        $username = $this->loginView->getUsername();
        $password = $this->loginView->getPassword();   
        $this->userModel->setUsername($username); 
        $this->userModel->setPassword($password);
    }

    public function logIn(){
        if($this->loginView->submitForm()){
            $this->setUsernameAndPassword();
            if($this->userModel->correctUsernameAndPassword()){     
                return true;  
            } else if($this->notCorrectLogIn()){
                return false;
            }   
               
        } 
    }

    public function logInCookie(){
        if($this->loginView->submitForm() && $this->loginView->keepMeLoggedIn()){
            $this->setUsernameAndPassword();
            if($this->userModel->correctUsernameAndPassword()){
                $this->loginView->setCookie();
                return true;
            } else {
                return false;
            }

        }

        // if($this->loginView->keepMeLoggedIn()){
        //     echo "hdhdhd";
        //     $this->loginView->setCookie();
        //    // $this->userModel->setCookieMessage();
        //    $message = $this->userModel->getMessage();
        //    $this->loginView->setMessage($message);
        //    echo "fjfjfj";
        //     //kalla på funktion i vyn som sätter cookies
        //     //return true också ? 
        // }
    }

    public function notCorrectLogIn(){
        if($this->userModel->emtyFields() || $this->userModel->emptyPasswordField() || $this->userModel->emptyUsername()||$this->userModel->wrongNameOrPassword()){
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
            $this->userModel->setRegisterUsername($usernameRegister);
            $this->userModel->setRegisterPassword($passwordRegister);
            $this->userModel->setPasswordRepeat($passwordRepeat);

            if($this->registerNotOk()){
                return false;
            }
        }
    }

    public function registerNotOk(){
        if($this->userModel->emtypFieldsRegister() || $this->userModel->emptyPasswordRegister() || $this->userModel->shortUsername() || $this->userModel->shortPassword() ||
        $this->userModel->notOkPasswordRepeat() || $this->userModel->userExist() || $this->userModel->checkForTags()){
            return true;
        } else {
            return false;
        }
    }

    

   


   

    



   

    


}