<?php

class Create extends Controller {

  public function index() {		
    $this->view('create/index');
  }

  public function createUser() { 
    /*
    1a. Will call function checkUsernameExists(username) in Model User
    1b. if userExists sets session variable usernameExists to true, then send to View Login
    1c. View Login will display error username taken if that session variable is true
    2. this function will check if passwords match. if not, set a session variable and
    direc to View Login (will display an error message)
    3. this function will check if password is 8 char. if not, set a session variable and
    direct to View Login (will display an error message)
    */
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];


    $user = $this->model('User');
    $user->checkUsernameExists($username); 
    // echo $_SESSION['test']; // for testing, yes this does call the fxn in User
    if (isset($_SESSION['username_exists']) && $_SESSION['username_exists'] == true) {
      header('location: /create');
    }
    else {
      header('location: /login');
    }
  }
}
