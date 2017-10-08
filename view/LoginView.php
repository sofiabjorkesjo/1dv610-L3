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
	private $message;
	public static $linkName = 'Register a new user';


	public function __construct(){
	
	}

	public function setMessage($message){
		$this->message = $message;
	}


	public function submitForm(){
		if(isset($_POST['LoginView::Login'])){
			return true;
		} else {
			return false;
		}
	}

	public function setValue(){
        if(isset($_POST['LoginView::UserName'])){
            $value = $_POST['LoginView::UserName'];
            return $value;
        } else {
            return "";
        }   
    }

	public function showLinkRegister(){
		return '
		<a href="?register">' . self::$linkName . '</a>
		';
	}

	public function clickRegisterLink(){
		if(isset($_GET["register"])){
			return true;
		} else {
			return false;
		}
	}

	public function clickLogOut(){
		if(isset($_POST['LoginView::Logout'])){
			return true;
		} else {
			return false;
		}
	}
	
	public function generateLogoutButtonHTML() {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $this->message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	
	public function generateLoginFormHTML() {
		return '
		
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $this->message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' .$this->setValue() . '" />

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

	public function getPassword(){
		$password = (isset($_POST['LoginView::Password']) ? $_POST['LoginView::Password'] : null);
		return $password;
	}

	public function keepMeLoggedIn(){
		if(isset($_POST['LoginView::KeepMeLoggedIn'])){
			return true;
		} else {
			return false;
		}
	}

	public function setCookie(){
		if(!isset($_COOKIE["LoginView::CookieName"]) && !isset($_COOKIE["LoginView::CookiePassword"])){
			$cookie_name = "LoginView::CookieName";
			$cookie_value = "Admin";
			$name = "LoginView::CookiePassword";
			$value = hash('ripemd160', 'Password');
			setcookie($name, $value, time() + 12360, "/");
			setcookie($cookie_name, $cookie_value, time() + 12360, "/");
		}
	}

	public function checkCookie(){
		if (isset($_COOKIE["LoginView::CookieName"]) && isset($_COOKIE["LoginView::CookiePassword"])){
			return true;
		} else {
			return false;
		}
	}

	public function unsetCookie(){
		if(isset($_COOKIE["LoginView::CookieName"]) && isset($_COOKIE["LoginView::CookiePassword"])){
			setcookie("LoginView::CookiePassword", hash('ripemd160', 'Password'), time() - 12360, "/");
			setcookie("LoginView::CookieName", "Admin", time() - 12360, "/");
		}
	}



	
	
	
}