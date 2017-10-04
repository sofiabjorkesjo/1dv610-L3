<?php 

class Test{
    public function testar(){
        $response = $this->loginView->generateLoginFormHTML($message);
        return $response;
    }
}