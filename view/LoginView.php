<?php

//alla post & get
//kapsla in allt i get och set metoder
//returnera det
require_once('model/UserModel.php');



class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';



	public function __construct(){

	}

	public function response() {
		$message = "w";
		$this->setMessage($message);
		
		
		$response = $this->generateLoginFormHTML($message);
		//$response .= $this->generateLogoutButtonHTML($message);
		return $response;
		

	}

	public function submitForm(){
		if(isset($_POST['LoginView::Login'])){
			return true;
		} else {
			return false;
		}
	}

	public function setMessage($message){
		return $message;
	}

	
	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	
	private function generateLoginFormHTML($message) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}

	public function getUsername(){
		$username = (isset($_POST['LoginView::UserName']) ? $_POST['LoginView::UserName'] : null);
		return $username;
	}

	private function getPassword(){
		$password = (isset($_POST['LoginView::Password']]) ? $_POST['LoginView::Password']] : null);
		return $password;
	}

	
	
	
}