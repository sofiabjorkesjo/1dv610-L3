<?php

class LayoutView {

  private $loggedIn;
  
  public function render($isLoggedIn, LoginView $loginView, $body, $link, DateTimeView $dateTimeView) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 3</h1>
          ' . $this->renderIsLoggedIn($isLoggedIn) . '
          ' . $link . '
          <div class="container">
              ' . $body . '    
              ' . $dateTimeView->show() . '
          </div>
         </body>
      </html>
    ';
  }
  
  private function renderIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2> 
      <div class="container">' ; 
    } else {
      return '<h2>Not logged in</h2>';
    }
  }
}
