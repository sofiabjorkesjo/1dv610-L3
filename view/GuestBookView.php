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
}