<?php

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
	public static $linkNameGuestBook = "Guestbook";

	public function __construct() {
	
	}

	public function setMessage($message) {
		$this->message = $message;
	}

	public function submitForm() {
		if(isset($_POST[self::$login])) {
			return true;
		} else {
			return false;
		}
	}

	public function showLinkRegister() {
		return '
		<a href="?register">' . self::$linkName . '</a>
		';
	}

	public function clickRegisterLink() {
		if(isset($_GET["register"])) {
			return true;
		} else {
			return false;
		}
	}

	public function showLinkGuestbook() {
		return '
		<a href="?guestbook">' . self::$linkNameGuestBook . '</a>
		';
	}

	public function clickGuestbookLink() {
		if(isset($_GET["guestbook"])) {
			return true;
		} else {
			return false;
		}
	}

	public function clickLogOut() {
		if(isset($_POST[self::$logout])) {
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

	public function getUsername() {
		$username = (isset($_POST[self::$name]) ? $_POST[self::$name] : null);
		return $username;
	}

	public function getPassword() {
		$password = (isset($_POST[self::$password]) ? $_POST[self::$password] : null);
		return $password;
	}

	public function keepMeLoggedIn() {
		if(isset($_POST[self::$keep])) {
			return true;
		} else {
			return false;
		}
	}

	public function setCookie() {
		if(!isset($_COOKIE[self::$cookieName]) && !isset($_COOKIE[self::$cookiePassword])) {
			$cookie_name = self::$cookieName;
			$cookie_value = "Admin";
			$name = self::$cookiePassword;
			$value = hash('ripemd160', $this->getPassword());
			setcookie($name, $value, time() + 12360, "/");
			setcookie($cookie_name, $cookie_value, time() + 12360, "/");
		}
	}

	public function checkCookie() {
		if (isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword])) {
			return true;
		} else {
			return false;
		}
	}

	public function unsetCookie() { 
		if(isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword])) {
			setcookie(self::$cookiePassword, hash('ripemd160', 'Password'), time() - 12360, "/");
			setcookie(self::$cookieName, "Admin", time() - 12360, "/");
		}
	}
	
	private function setValue() {
        if(isset($_POST[self::$name])) {
            $value = $_POST[self::$name];
            return $value;
        } else {
            return "";
        }   
    }
}