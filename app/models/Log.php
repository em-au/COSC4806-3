<?php

class Log {

  public $username;
  public $success;
  public $time;

  // public function __construct() {

  // }

  // Adds the login attempt to Logs table in database
  public function log_attempt($username, $success, $time) {
    $db = db_connect();
    $statement = $db->prepare("INSERT INTO logs (username, success, time) VALUES (:username, :success, :time)");
    $statement->bindParam(':username', $username);
    $statement->bindParam(':success', $success);
    $statement->bindParam(':time', $time);
    $statement->execute();
  }

  // Returns the time of the last failed attempt
  public function lock_time($username) {
    $db = db_connect();
    $statement = $db->prepare("SELECT time FROM logs WHERE username = :username AND success = 0 ORDER BY time DESC LIMIT 1");
    $statement->bindParam(':username', $username);
    $statement->execute();
    $rows = $statement->fetch(PDO::FETCH_ASSOC);
    $time = $rows['time'];
    return $time;
  }
}
?>