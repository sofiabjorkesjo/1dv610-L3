<?php

class GuestBookView {
    
    private static $text = "GuestBookViewView::Text";
    private static $send = "GuestBookViewView::Send";

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
}