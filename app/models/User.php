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
      $_SESSION['username'] = ucwords($username);
      unset($_SESSION['failedAuth']);
      header('Location: /home'); // should this be done by the controller?
      die;
    } else {
      if(isset($_SESSION['failedAuth'])) {
        $_SESSION['failedAuth'] ++; //increment
      } else {
        $_SESSION['failedAuth'] = 1;
      }
      header('Location: /login'); // should this be done by the controller?
      die;
    }
  }

  // Check if username exists in the database
  // think i need to bind a value like in the authenticate fxn for security reasons 
  public function checkUsernameExists($username) {
    $_SESSION['test'] = 'test';
    $db = db_connect();
    $statement = $db->prepare("SELECT username FROM users WHERE username = '$username'");
    $statement->execute(); 
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    
    if (isset($row) && !empty($row)) {
      $_SESSION['usernameExists'] = true;
    }
    else {
      $_SESSION['usernameExists'] = false;
    }
    // die;
  }

}
