<?php

require_once('controller/Controller.php');

error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();

$controller = new Controller();
$controller->showView();


