<?php

class Login extends Controller {

    public function index() {		
	    $this->view('login/index');
    }
    
    public function verify() {
			$username = $_REQUEST['username'];
			$password = $_REQUEST['password'];

			$user = $this->model('User');
			$user->check_username_exists($username);
			if (isset($_SESSION['username_exists']) && $_SESSION['username_exists'] == 0) {
				header('location: /login');
				die;
			}
			$user->authenticate($username, $password); 
			
			// Log attempt in Logs table in database
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

			// Check if user should be locked out
			$this->lock(); 
    }

		public function lock() {
			if ($_SESSION['failedAuth'] >= 3) {
				$_SESSION['locked'] = 1;
				$log = $this->model('Log');
				$_SESSION['lock_start'] = $log->lock_time($_SESSION['username']);
				$_SESSION['lock_end'] = strtotime($_SESSION['lock_start']) + 5; // CHANGE BACK TO 60 SEC
			}
		}

}
?>
