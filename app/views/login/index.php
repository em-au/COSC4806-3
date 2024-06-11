<?php require_once 'app/views/templates/headerPublic.php'?>
<main role="main" class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Log in</h1>
            </div>
        </div>
    </div>

<?php
	if (isset($_SESSION['account_created']) && $_SESSION['account_created'] == 1) {
			echo "Account created! Please log in.";
	}
	
	// Unset variables so error messages don't persist (eg when refreshing page)
	unset($_SESSION['account_created']);
	echo "\n\n";
?>

<div class="row">
    <div class="col-sm-auto">
		<form action="/login/verify" method="post" >
		<fieldset>
			<div class="form-group">
				<label for="username">Username</label>
				<input required type="text" class="form-control" name="username">
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input required type="password" class="form-control" name="password">
			</div>
			<?php
				if (isset($_SESSION['username_exists']) && ($_SESSION['username_exists'] == 0)) {
					echo "Username does not exist";
					unset($_SESSION['username_exists']);
				}
				if (isset($_SESSION['failedAuth'])) { // can't unset this bc need to keep track?
					echo "Password is incorrect";
				}

			?>
			<br>
			<button type="submit" class="btn btn-primary" 
				<?php 
				$test = new Login();
				$test->unlock();
				if (isset($_SESSION['locked'])) { ?> disabled <?php } ?>>Login</button>
		</fieldset>
		</form> 
	</div>
</div>

<?php
	echo $_SESSION['locked'];
	echo " " . $_SESSION['failedAuth'];
	echo "why" . $_SESSION['lock_start'];
	echo "\n time" . time();
?>
					

					
<footer>
		<a href="/create">Don't have an account? Sign up now.</a>
</footer>
<br>
	
<?php require_once 'app/views/templates/footer.php' ?>
