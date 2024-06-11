<?php

class User {

  public $username;
  public $password;
  public $auth = false;

  public function __construct() {
      
  }

  public function test () {
    $db = db_connect();
    $statement = $db->prepare("select * from users;");
    $statement->execute();
    $rows = $statement->fetch(PDO::FETCH_ASSOC);
    return $rows;
  }

  public function authenticate($username, $password) {
      /*
       * if username and password good then
       * $this->auth = true;
       */
    $username = strtolower($username);
    $db = db_connect();
        $statement = $db->prepare("select * from users WHERE username = :name;");
        $statement->bindValue(':name', $username);
        $statement->execute();
        $rows = $statement->fetch(PDO::FETCH_ASSOC);
    
    if (password_verify($password, $rows['password'])) {
      $_SESSION['auth'] = 1;
      $_SESSION['username'] = ucwords($username); // use this to display username in Home
      unset($_SESSION['failedAuth']);
      header('Location: /home'); // should this be done by the controller?
      //die;
    } else {
      if(isset($_SESSION['failedAuth'])) {
        $_SESSION['failedAuth'] ++; //increment
      } else {
        $_SESSION['failedAuth'] = 1;
      }
      header('Location: /login'); // should this be done by the controller?
      //echo $_SESSION['failedAuth'];
      //echo $_SESSION['locked'];
      //die;
    }
  }

  // Check if username exists in the Users table in database
  // think i need to bind a value/param like in the authenticate fxn for security reasons - lect4
  public function check_username_exists($username) {
    $db = db_connect();
    $statement = $db->prepare("SELECT username FROM users WHERE username = '$username'");
    $statement->execute(); 
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if (isset($row) && !empty($row)) {
      $_SESSION['username_exists'] = 1;
    }
    else {
      $_SESSION['username_exists'] = 0;
    }
    // die;
  }

  // Add new user to the Users table
  // think i need to bind a value like in the authenticate fxn for security reasons 
  public function add_user($username, $password) {
    $db = db_connect();
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $statement = $db->prepare("INSERT into users (username, password) VALUES ('$username','$hashed_password')");
    $statement->execute();
  }

}
