<?php 

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
    private $body;
    private $link;

    public function __construct() {
        $this->layoutView = new LayoutView();
        $this->dateTimeView = new DateTimeView(); 
        $this->loginView = new LoginView();
        $this->userModel = new UserModel();
        $this->registerView = new RegisterView();    
    }

    public function showView() {
       $this->body = $this->setBody();
       if($this->body == $this->loginView->generateLogoutButtonHTML()) {
            $this->layoutView->render(true, $this->loginView, $this->body, $this->link, $this->dateTimeView);
       } else {
            $this->layoutView->render(false, $this->loginView, $this->body, $this->link,  $this->dateTimeView);
       }
    }

    private function setBody() {  
        $this->link = $this->loginView->showLinkRegister();   
        $this->body = $this->loginView->generateLoginFormHTML();
  
        if($this->logInCookie()) {
            $this->showViewLogInCookie();
        } else if($this->stayLoggedInCookie()) {
            $this->showViewStayLoggedIn();
        } else if($this->logIn()) {
            $this->showViewLogIn();
        } else if ($this->userModel->userLoggedIn()) { 
            $this->body = $this->loginView->generateLogoutButtonHTML();
        } else if($this->logIn() == false) {
            $this->showViewNotLoggedIn();
        }

        if($this->logOut()) {
            $this->showViewLoggedOut();
        }
        //FIXA else
        if($this->loginView->clickRegisterLink()) {
            $this->showViewRegister();
        }  
        return $this->body;
    }

    private function showViewLogInCookie(){
        $this->userModel->setCookieMessage();
        $message = $this->userModel->getMessage();
        $this->loginView->setMessage($message);
        $this->body = $this->loginView->generateLogoutButtonHTML();
    }

    private function showViewStayLoggedIn(){
        $this->userModel->setSession();
        $message = $this->userModel->getMessage();
        $this->loginView->setMessage($message);
        $this->body = $this->loginView->generateLogoutButtonHTML();
    }

    private function showViewLogIn(){
        //FIXA PÅ ANNAT SÄTT?
        if($this->userModel->ifSetMessageLogIn()){
            $message = $this->userModel->getMessage();
            $this->loginView->setMessage($message);
        }      
        $this->body = $this->loginView->generateLogoutButtonHTML();
    }

    private function showViewNotLoggedIn(){
        $message = $this->userModel->getMessage();
        $this->loginView->setMessage($message);
        $this->link = $this->loginView->showLinkRegister(); 
        $this->body = $this->loginView->generateLoginFormHTML();
    }

    private function showViewLoggedOut(){
        //FIXA PÅ ANNAT SÄTT?
        if($this->userModel->ifSetMessageLogOut()) { 
            $message = $this->userModel->getMessage();
            $this->loginView->setMessage($message);
        }
        $this->loginView->unsetCookie();   
        $this->link = $this->loginView->showLinkRegister(); 
        $this->body = $this->loginView->generateLoginFormHTML();
    }

    private function showViewRegister(){
        if($this->register() == false) {
            $message = $this->userModel->getMessage();
            $this->registerView->setMessageRegister($message);
        }
        $this->link = $this->registerView->showLinkBack();
        $this->body = $this->registerView->generateRegisterForm();
    }

    private function getUsernameAndPassword() {
        $username = $this->loginView->getUsername();
        $password = $this->loginView->getPassword();   
        $this->userModel->setUsername($username); 
        $this->userModel->setPassword($password);
    }

    private function logIn() {
        if($this->loginView->submitForm()) {
            $this->getUsernameAndPassword();
            if($this->userModel->correctUsernameAndPassword()) {     
                return true;  
            } else if($this->notCorrectLogIn()) {
                return false;
            }           
        } 
    }

    private function logInCookie() {
        if($this->loginView->submitForm() && $this->loginView->keepMeLoggedIn()) {
            $this->getUsernameAndPassword();
            if($this->userModel->correctUsernameAndPassword()) {
                $this->loginView->setCookie();
                return true;
            } else {
                return false;
            }

        }
    }

    private function stayLoggedInCookie() {
        if($this->loginView->checkCookie() && $this->userModel->checkSession()) {
            $this->userModel->setSession();
            return true;
        } else {
            return false;
        }
    }

    private function notCorrectLogIn() {
        if($this->userModel->emtyFields() || $this->userModel->emptyPasswordField() || $this->userModel->emptyUsernameField()||$this->userModel->wrongNameOrPassword()) {
            return true;
        } else {
            return false;
        }
    }

    private function logOut(){
        if($this->loginView->clickLogOut()){
            $this->userModel->loggOutUser();
            return true;
        } else {
            return false;
        }
    }

    private function getUsernameAndPasswordRegister(){
        $usernameRegister = $this->registerView->getUsernameRegister();
        $passwordRegister = $this->registerView->getPasswordRegister();
        $passwordRepeat = $this->registerView->getPasswordRepeat();
        $this->userModel->setRegisterUsername($usernameRegister);
        $this->userModel->setRegisterPassword($passwordRegister);
        $this->userModel->setPasswordRepeat($passwordRepeat);
    }

    private function register() {
        if($this->registerView->clickRegister()) {
            $this->getUsernameAndPasswordRegister();
            if($this->registerNotOk()) {
                return false;
            }
        }
    }

    private function registerNotOk() {
        if($this->userModel->emtypFieldsRegister() || $this->userModel->emptyPasswordRegister() || $this->userModel->shortUsername() || $this->userModel->shortPassword() ||
        $this->userModel->notOkPasswordRepeat() || $this->userModel->userExist() || $this->userModel->checkForTags()) {
            return true;
        } else {
            return false;
        }
    }
}