<?php 

require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');
require_once('view/GuestBookView.php');
require_once('model/LoginModel.php');
require_once('model/GuestbookModel.php');
require_once('model/RegisterModel.php');

class Controller{

    private $layoutView;
    private $dateTimeView;
    private $loginView;
    private $registerView;
    private $loginModel;
    private $registerModel;
    private $guestbookModel;
    private $body;
    private $link;

    public function __construct() {
        $this->layoutView = new LayoutView();
        $this->dateTimeView = new DateTimeView(); 
        $this->loginView = new LoginView();
        $this->loginModel = new LoginModel();
        $this->registerModel = new RegisterModel();
        $this->guestbookModel = new GuestbookModel();
        $this->registerView = new RegisterView();  
        $this->guestBookView = new GuestBookView();     
    }

    public function showView() {
        $this->body = $this->setBody();
        $this->getTextToGuessedBook();
        if($this->body == $this->guestBookView->generateGuestBookView() . $this->loginView->generateLogoutButtonHTML() || $this->body == $this->guestBookView->showGuestBookText() . $this->loginView->generateLogoutButtonHTML()) {
            $this->layoutView->render(true, $this->loginView, $this->body, $this->link, $this->dateTimeView);
        } else {
            $this->layoutView->render(false, $this->loginView, $this->body, $this->link, $this->dateTimeView);
        }
    }

    private function setBody() { 
        if($this->loginView->clickRegisterLink()) {
            $this->showViewRegister(); 
        } else if($this->logInCookie()) {
            $this->showViewLogInCookie();
        } else if($this->stayLoggedInCookie()) {
            $this->showViewStayLoggedIn();
        } else if($this->logIn() || $this->loginModel->userLoggedIn()) {
            $this->showViewLogIn();
        } else if($this->logIn() == false) {
            $this->showViewLoggedOut();
        }

        if($this->goToGuestbook() && $this->loginModel->userLoggedIn()) {
            $this->link = $this->guestBookView->linkBackToLoggedIn();
            $this->body = $this->guestBookView->showGuestBookText();
            $this->body .= $this->loginView->generateLogoutButtonHTML();
        } else if($this->goToGuestbook() && $this->loginModel->userLoggedIn() == false){
            $this->guestbookModel->messageNotLoggedIn();
            $message = $this->guestbookModel->getMessage();
            $this->guestBookView->setMessage($message);
            $this->link = $this->guestBookView->linkBackToLoggedIn();
            $this->body = $this->guestBookView->showGuestBookText();
        }

        if($this->logOut()) {
            $this->showViewLoggedOut();
        }
        return $this->body;
    }

    private function guestbookAndLogOut(){
        $this->body = $this->guestBookView->generateGuestBookView();       
        $this->body .= $this->loginView->generateLogoutButtonHTML();
    }

    public function getTextToGuessedBook() {
        if($this->guestBookView->sendText()) {
            $textToFile = $this->guestBookView->getText();
            $this->guestbookModel->setText($textToFile);
            if($this->guestbookModel->checkText() == true){
                $message = $this->guestbookModel->getMessage();
                $this->loginView->setMessage($message);
                $text = $this->guestbookModel->sendToController();
                $this->guestBookView->setTextToView($text);
                $textToFile = $this->guestBookView->textInTag();
                $this->guestbookModel->writeToFile($textToFile);
                $this->link = $this->loginView->showLinkGuestbook();
                $this->guestbookAndLogOut();
            } else if($this->guestbookModel->checkText() == false){
                //katsa exception eller nått kanske
                $message = $this->guestbookModel->getMessage();
                $this->loginView->setMessage($message);
                $this->link = $this->loginView->showLinkGuestbook();
                $this->guestbookAndLogOut();
            }
        }
    }

    //FIXA
    private function showViewLogInCookie(){
        $this->loginModel->setCookieMessage();
        $message = $this->loginModel->getMessage();
        $this->loginView->setMessage($message);
        $this->link = $this->loginView->showLinkGuestbook();
        $this->guestbookAndLogOut();
    }

    //FIXA
    private function showViewStayLoggedIn(){
        $this->loginModel->setSession();
        $message = $this->loginModel->getMessage();
        $this->loginView->setMessage($message);
        $this->link = $this->loginView->showLinkGuestbook();
        $this->guestbookAndLogOut();
    }

    private function showViewLogIn(){
        $message = $this->loginModel->getMessage();
        $this->loginView->setMessage($message);
        $this->link = $this->loginView->showLinkGuestbook();
        $this->guestbookAndLogOut();
    }

    private function showViewLoggedOut(){
        $message = $this->loginModel->getMessage();
        $this->loginView->setMessage($message);
        if($this->loginView->checkCookie()){
            $this->loginView->unsetCookie();  
        }  
        $this->link = $this->loginView->showLinkRegister(); 
        $this->body = $this->loginView->showLinkGuestbook();
        $this->body .= $this->loginView->generateLoginFormHTML();
    }

    private function showViewRegister(){
        if($this->register() == false) {
            $message = $this->registerModel->getMessage();
            $this->registerView->setMessageRegister($message);
        }
        $this->link = $this->registerView->showLinkBack();
        $this->body = $this->registerView->generateRegisterForm();
    }

    private function getUsernameAndPassword() {
        $username = $this->loginView->getUsername();
        $password = $this->loginView->getPassword();   
        $this->loginModel->setUsername($username); 
        $this->loginModel->setPassword($password);
    }

    private function logIn() {
        if($this->loginView->submitForm()) {
            $this->getUsernameAndPassword();
            if($this->loginModel->correctUsernameAndPassword()) {  
                return true;  
            } else if($this->notCorrectLogIn()) {
                return false;
            }           
        } 
    }

    private function logInCookie() {
        if($this->loginView->submitForm() && $this->loginView->keepMeLoggedIn()) {
            $this->getUsernameAndPassword();
            if($this->loginModel->correctUsernameAndPassword()) {
                $this->loginView->setCookie();
                return true;
            } else {
                return false;
            }

        }
    }

    private function stayLoggedInCookie() {
        if($this->loginView->checkCookie() && $this->loginModel->checkSession()) {
            $this->loginModel->setSession();
            return true;
        } else {
            return false;
        }
    }

    private function notCorrectLogIn() {
        if($this->loginModel->emtyFields() || $this->loginModel->emptyPasswordField() || $this->loginModel->emptyUsernameField()||$this->loginModel->wrongNameOrPassword()) {
            return true;
        } else {
            return false;
        }
    }

    private function logOut(){
        if($this->loginView->clickLogOut()){
            $this->loginModel->loggOutUser();
            return true;
        } else {
            return false;
        }
    }

    private function getUsernameAndPasswordRegister(){
        $usernameRegister = $this->registerView->getUsernameRegister();
        $passwordRegister = $this->registerView->getPasswordRegister();
        $passwordRepeat = $this->registerView->getPasswordRepeat();
        $this->registerModel->setRegisterUsername($usernameRegister);
        $this->registerModel->setRegisterPassword($passwordRegister);
        $this->registerModel->setPasswordRepeat($passwordRepeat);
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
        if($this->registerModel->emtypFieldsRegister() || $this->registerModel->emptyPasswordRegister() || $this->registerModel->shortUsername() || $this->registerModel->shortPassword() ||
        $this->registerModel->notOkPasswordRepeat() || $this->registerModel->userExist() || $this->registerModel->checkForTags()) {
            return true;
        } else {
            return false;
        }
    }

    private function goToGuestbook() {
        if($this->loginView->clickGuestbookLink()) {
            return true;
        } else {
            return false;
        }
    }
}