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
			$this->lock(); // Check if user should be locked out
			
			// Log attempt 
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

		public function lock() {
			if ($_SESSION['failedAuth'] >= 3) {
				$_SESSION['locked'] = 1;
				$_SESSION['lock_end'] = time() + 5; // CHANGE BACK TO 60 SEC
			}
		}

}
?>
