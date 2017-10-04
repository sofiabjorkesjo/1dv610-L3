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
require_once('model/UserModel.php');

class Controller{

    private $layoutView;
    private $dateTimeView;
    private $loginView;
    private $userModel;
    private $test;
    private $body;

    public function __construct(){
        $this->layoutView = new LayoutView();
        $this->dateTimeView = new DateTimeView(); 
        $this->loginView = new LoginView();
        $this->userModel = new UserModel();
       
    }

    public function showView(){
       $this->body = $this->setBody();        
        $this->layoutView->render(false, $this->loginView, $this->body, $this->dateTimeView);
        $this->tryLogIn();
    }

    public function setBody(){
        $this->body = $this->loginView->generateLoginFormHTML($message);
        //FIXA SÅ DE ÄR NÄR MAN ÄR INLOGGAD !!
        if($this->tryLogIn()){
            echo "mmmm";
            $this->body = $this->loginView->generateLogoutButtonHTML($message);  
        }
        return $this->body;
    }

    public function tryLogIn(){
        if($this->loginView->submitForm()){
            $username = $this->loginView->getUsername();
            $password = $this->loginView->getPassword();
            
            $this->userModel->setUsername($username); 
            $this->userModel->setPassword($password);
            //if fields ej ok = ej inloggad
            //annars inloggad
            //kolla om användar stämmer -> loggas in
            //ej stämmer -> ej loggas in
            //$this->isLoggedIn();   
            return true;     
        } 
    }

  

    // public function loggedIn(){      
    //     echo " mm ";
    //     return true;
    // } 

   

    



   

    


}