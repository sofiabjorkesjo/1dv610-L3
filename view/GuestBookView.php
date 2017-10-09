<?php

class GuestBookView {
    
    private static $text = "GuestBookViewView::Text";
    private static $send = "GuestBookViewView::Send";
    private static $guestBook = "GuestBookViewView::GuestBook";
    private static $linkName = "Show guestbook";
    private $textSave;
    public static $linkNameBack = "Back";

    public function __construct() {
        
    }


	public function generateGuestBookView() {
        return '
            <h2>Write in guestbook</h2>	
			<form method="post"> 	
					<label for="' . self::$text . '">Write here :</label>
					<input type="text" id="' . self::$text . '" name="' . self::$text . '" value="" />	
					<input type="submit" name="' . self::$send . '" value="send" />
			</form>
		';
    }
    
    
    public function getText() {
        $text =  (isset($_POST[self::$text]) ? $_POST[self::$text] : null);
        echo $text;
        return $text;
    }

    public function sendText() {
        if(isset($_POST[self::$send])) {
            return true;
        } else {
            return false;
        }
    }

    public function writeFileToView() {
        $file = file_get_contents("guestBook.txt");
        return $file;

    }

    public function showGuestBookText(){
        echo "jdjd";
        return '
            <h2>Guestbook</h2>
            <div>
              "'. $this->writeFileToView() .'"
            </div>
        ';
    }

    public function linkBackToLoggedIn(){
        return '
		<a href="?">' . self::$linkNameBack . '</a>
		';
    }

    public function getBack(){
        if(isset($_GET["?"])) {
            echo "true back";
            return true;
        } else {
            echo "bl'";
            return false;
        }
    }
}