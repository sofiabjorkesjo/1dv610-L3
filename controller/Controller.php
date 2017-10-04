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

    public function showView(){
        $this->layoutView = new LayoutView();
        $this->dateTimeView = new DateTimeView(); 
        $this->loginView = new LoginView();

        $this->layoutView->render(false, $this->loginView, $this->dateTimeView);
        $this->loginView->setMessage("hejhej"); 
        $this->isLoggedIn();
    }

    public function isLoggedIn(){
        if($this->loginView->submitForm()){
            $username = $this->loginView->getUsername();
            $this->userModel = new UserModel();
            $this->userModel->setUsername($username);
            //modellen . setUsername($username);
           // echo "yoyoy ";
            //$this->loginView->getUsername();
           // $this->
            
        }
    }


}