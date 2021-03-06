<?php 

class RegisterView {

    private static $username = "RegisterView::UserName";
    private static $password = "RegisterView::Password";
    private static $repeatPassword = "RegisterView::PasswordRepeat";
    private static $registration = "RegisterView::Register";
    private static $messageId = "RegisterView::Message";
    private static $link = "Back to login";
    private $message;

    public function showLinkBack() {
        return '
        <a href="?">' . self::$link . '</a>
        ';
    }

    public function clickRegister() {
        if(isset($_POST["RegisterView::Register"])) {
            return true;
        } else {
            return false;
        }
    }

    public function setMessageRegister($message) {
        $this->message = $message;
    }

    public function generateRegisterForm() {
        return '   
        <h2>Register new user</h2>
        <form action="?register" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Register a new user - Write username and password</legend>
                <p id="' . self::$messageId  . '">' . $this->message . '</p>
                <label for="' . self::$username . '">Username :</label>
                <input type="text" size="20" name="' . self::$username . '" id="' . self::$username .'" value="' . $this->setValue() .'">
                <br>
                <label for="' . self::$password .'">Password :</label>
                <input type="password" size="20" name="' . self::$password . '" id="' . self::$password . '" value>
                <br>
                <label for="' . self::$repeatPassword . '">Repeat password :</label>
                <input type="password" size="20" name="' . self::$repeatPassword .'" id="' . self::$repeatPassword . '" value>
                <br>
                <input id="submit" type="submit" name="' . self::$registration . '" value="Register">
                <br>
                </fieldset>
                </form>			
        ';
    }

    public function getUsernameRegister() {
        $username =  (isset($_POST[self::$username]) ? $_POST[self::$username] : null);
        return $username;	
    }

    public function getPasswordRegister() {
        $password =  (isset($_POST[self::$password]) ? $_POST[self::$password] : null);
        return $password;
    }

    public function getPasswordRepeat() {
        $passwordRepeat = (isset($_POST[self::$repeatPassword]) ? $_POST[self::$repeatPassword] : null);
        return $passwordRepeat;
    }

    private function setValue() {
        if(isset($_POST[self::$username])) {
            $value = $_POST[self::$username];
            return strip_tags($value);
        } else {
            return "";
        }   
    }
}