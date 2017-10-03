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
    public function start(){
        $layoutView = new LayoutView();
        $dateTimeView = new DateTimeView(); 
        $loginView = new LoginView();

        $layoutView->render(false, $loginView, $dateTimeView);

        //echo "hejhej";
    }
}