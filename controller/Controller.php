<?php 

require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');
require_once('view/GuestBookView.php');
require_once('model/UserModel.php');

class Controller{

    private $layoutView;
    private $dateTimeView;
    private $loginView;
    private $registerView;
    private $userModel;
    private $body;
    private $link;
    private $guestBook;
    private $test;
    private $linkGuestBook;
    private $guestBookText;

    public function __construct() {
        $this->layoutView = new LayoutView();
        $this->dateTimeView = new DateTimeView(); 
        $this->loginView = new LoginView();
        $this->userModel = new UserModel();
        $this->registerView = new RegisterView();  
        $this->guestBookView = new GuestBookView();
    }

    public function showView() {
        $this->body = $this->setBody();
        $this->getTextToGuessedBook();
        if($this->body == $this->guestBookView->generateGuestBookView() . $this->loginView->generateLogoutButtonHTML() || $this->body == $this->guestBookView->showGuestBookText() . $this->loginView->generateLogoutButtonHTML()) {
            $this->layoutView->render(true, $this->loginView, $this->body, $this->link, $this->guestBook, $this->guestBookText, $this->dateTimeView);
        } else {
            $this->guestBook = "";
            $this->guestBookText = "";
            $this->layoutView->render(false, $this->loginView, $this->body, $this->link, $this->guestBook, $this->guestBookText, $this->dateTimeView);
        }
    }

    private function setBody() {  
        $this->link = $this->loginView->showLinkRegister();
        $this->body = $this->loginView->generateLoginFormHTML();
        if($this->loginView->clickRegisterLink()) {
            $this->showViewRegister(); 
        } else if($this->logInCookie()) {
            $this->showViewLogInCookie();
        } else if($this->stayLoggedInCookie()) {
            $this->showViewStayLoggedIn();
        } else if($this->logIn() || $this->userModel->userLoggedIn()) {
            $this->showViewLogIn();
        } else if($this->logIn() == false) {
            $this->showViewLoggedOut();
        }

        if($this->goToGuestbook()) {
            $this->link = $this->guestBookView->linkBackToLoggedIn();
            $this->body = $this->guestBookView->showGuestBookText();
            $this->body .= $this->loginView->generateLogoutButtonHTML();
        }

        if($this->logOut()) {
            $this->showViewLoggedOut();
        }
        return $this->body;
    }

    public function getTextToGuessedBook() {
            if($this->guestBookView->sendText()) {
                $textToFile = $this->guestBookView->getText();
                $this->userModel->setText($textToFile);
                if($this->userModel->checkText()){
                    $this->userModel->writeToFile();
                    $this->link = $this->loginView->showLinkGuestbook();
                    $this->body = $this->guestBookView->generateGuestBookView();       
                    $this->body .= $this->loginView->generateLogoutButtonHTML();
                } else {
                    //katsa exception eller nått kanske
                }
            }
    }

    private function notLoggedIn() {
        if ($this->logOut() || $this->logIn() == false) {
            return true;
        } else {
            return false;
        }
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
        echo "mm";
        
        $message = $this->userModel->getMessage();
        echo $message;
        $this->loginView->setMessage($message);
        $this->link = $this->loginView->showLinkGuestbook();
        $this->body = $this->guestBookView->generateGuestBookView();       
        $this->body .= $this->loginView->generateLogoutButtonHTML();
    }

    private function showViewLoggedOut(){
        $message = $this->userModel->getMessage();
        $this->loginView->setMessage($message);
        if($this->loginView->checkCookie()){
            $this->loginView->unsetCookie();  
        }  
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

    private function goToGuestbook() {
        if($this->loginView->clickGuestbookLink()) {
            return true;
        } else {
            return false;
        }
    }

    private function back(){
        if($this->guestBookView->getBack()) {
            return true;
        } else {
            return false;
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