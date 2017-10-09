<?php

class GuestBookView {
    
    private static $text = "GuestBookViewView::Text";
    private static $send = "GuestBookViewView::Send";
    private static $guestBook = "GuestBookViewView::GuestBook";
    private $textSave;

    public function __construct() {
        
    }


	public function generateGuestBookView() {
		return '	
			<form method="post" > 
				<fieldset>
					<legend>Write something in the guestbook</legend>		
					<label for="' . self::$text . '">Write here :</label>
					<input type="text" id="' . self::$text . '" name="' . self::$text . '" value="" />	
					<input type="submit" name="' . self::$send . '" value="send" />
				</fieldset>
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
        echo $file;
        return $file;

    }

    public function showGuestBookView(){
        return '
            <div>
              "'. $this->writeFileToView() .'"
            </div>
        ';
    }
}