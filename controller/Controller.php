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

class Controller{

    private $layoutView;
    private $dateTimeView;
    private $loginView;

    public function showView(){
        $this->layoutView = new LayoutView();
        $this->dateTimeView = new DateTimeView(); 
        $this->loginView = new LoginView();

        $this->layoutView->render(false, $this->loginView, $this->dateTimeView);
        $this->isLoggedIn();
    }

    public function isLoggedIn(){
        if($this->loginView->submitForm()){
            echo "yoyoy ";
        }
    }


}