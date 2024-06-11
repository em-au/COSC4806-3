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
			//echo $_SESSION['failedAuth'];
			//echo " " . $_SESSION['locked'];
			
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
				$_SESSION['lock_start'] = time(); // Current time
				echo "this is from controller";
				echo "lock_start: " . $_SESSION['lock_start'];
				echo "\nCurrent time: " . time();
				//$_SESSION['end'] = time() + 5; // CHANGE TO 60 SECONDS
				//$this->unlock(); // Check if it has been 60 seconds

				// echo "\n\nsession variable locked: " . $_SESSION['locked']; //1 
				// unset($_SESSION['locked']);
				// echo "\n\nsession variable locked: " . $_SESSION['locked']; // none
			}
		}

		public function unlock() {
			if (time() > $_SESSION['lock_start'] + 5) {
				unset($_SESSION['locked']);
			}
		}

}
?>
