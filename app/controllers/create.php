<?php

class Create extends Controller {

  public function index() {		
    $this->view('create/index');
  }

  public function create_user() { 
    $username = $_REQUEST['username'];
    $password1 = $_REQUEST['password1'];
    $password2 = $_REQUEST['password2'];

    $user = $this->model('User');

    // Check if username exists
    $user->check_username_exists($username); 
    if (isset($_SESSION['username_exists']) && $_SESSION['username_exists'] == 1) {
      header('location: /create');
    }
      
    // Check if passwords match
    else if ($password1 != $password2) {
      $_SESSION['password_mismatch'] = 1;
      header ('location: /create');
    }

    // Check if password meets security standard (minimum 8 characters)
    else if (strlen($password1) < 8) {
      $_SESSION['password_too_short'] = 1;
      header ('location: /create');
    }
    else {
      // Passed all requirements
      // Create user in database --> should be done in Model User (so call fxn add_user)
      // Session variable account_created --> display as message on login page
      $user->add_user($username, $password1);
      //echo "test - called add user fxn" . $username . $password1; //works
      $_SESSION['account_created'] = 1;
      header('location: /login');
    }
  }
}
