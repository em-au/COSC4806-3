<?php

class Login extends Controller {

    public function index() {		
	    $this->view('login/index');
    }
    
    public function verify() {
			$username = $_REQUEST['username'];
			$password = $_REQUEST['password'];
			$user = $this->model('User');

			// Check if username exists
			$user->check_username_exists($username);
			if ($_SESSION['username_exists'] == 0) {
				header('location: /login');
				die;
			}

			// Check if password is correct
			$user->authenticate($username, $password); 
			if ($user->is_authenticated) {
				$_SESSION['auth'] = 1;

				unset($_SESSION['failedAuth']);
				header('location: /home');
			}
			else {
				$_SESSION['password_incorrect'] = 1;
				if(isset($_SESSION['failedAuth'])) {
					$_SESSION['failedAuth'] ++; //increment
				} 
				else {
					$_SESSION['failedAuth'] = 1;
				}
				header('location: /login');
			}

			$this->attempt($username);

			$this->lock(); 
    }

		// Call model to add login attempt to Logs table in database
		public function attempt($username) {
			$log = $this->model('Log');

			if ($_SESSION['auth'] == 1) {
				$success = 1; 
			}
			else if (isset($_SESSION['failedAuth'])) {
				$success = 0;
			}
			date_default_timezone_set('America/Toronto');
			$date = date('Y-m-d H:i:s');
			$log->log_attempt($username, $success, $date);
		}

		// Check if user should be locked out
		public function lock() {
			if ($_SESSION['failedAuth'] >= 3) {
				$_SESSION['locked'] = 1;
				$log = $this->model('Log'); // Call model to get time of last failed attempt
				$_SESSION['lock_start'] = $log->lock_time($_SESSION['username']);
				$_SESSION['lock_end'] = strtotime($_SESSION['lock_start']) + 60; 
			}
		}

}
?>
