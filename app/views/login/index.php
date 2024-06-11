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
			<?php // ERROR: username taken error message is persist
			if (isset($_SESSION['username_exists']) && ($_SESSION['username_exists'] == 0)) { ?>
					<span style="color: red">Username does not exist</span>
			 <?php }
			 if (isset($_SESSION['password_incorrect'])) { ?>
					<span style="color: red">Password is incorrect</span>
			<?php } ?>
			<br>	
			<button type="submit" class="btn btn-primary" 
				<?php // NEED TO CHANGE TIME BACK TO 60 SEC
				if (isset($_SESSION['locked']) && !(time() > $_SESSION['lock_start'] + 5)) { ?> disabled <?php } ?>>Login</button>
			<br>
			<?php 
					unset($_SESSION['username_exists']);
				 	unset($_SESSION['password_incorrect']);
			?>
		</fieldset>
		</form> 
	</div>
</div>
	<a href="/create">Don't have an account? Sign up now.</a>
<?php // NEED TO CHANGE TIME BACK TO 60 SEC
	if (isset($_SESSION['locked']) && !(time() > $_SESSION['lock_start'] + 5)) { ?>
		<br>
		<br>
		<div class="alert alert-danger" role="alert">
				You have been locked out. Please refresh the page and try again in 60 seconds.
		</div>
	<?php }
	else {
		unset($_SESSION['locked']);
	}
?>
			
<footer>

</footer>
<br>
	
<?php require_once 'app/views/templates/footer.php' ?>
