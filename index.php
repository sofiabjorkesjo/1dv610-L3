<?php

//Startar session
//skapar controllern
//felmeddelanden



require_once('controller/Controller.php');




//INCLUDE THE FILES NEEDED...
// require_once('view/LoginView.php');
// require_once('view/DateTimeView.php');
// require_once('view/LayoutView.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();

$controller = new Controller();
$controller->showView();

//CREATE OBJECTS OF THE VIEWS
// $v = new LoginView();
// $dtv = new DateTimeView();
// $lv = new LayoutView();


//$lv->render(false, $v, $dtv);


