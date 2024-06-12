<?php require_once 'app/views/templates/headerPublic.php'?>
<main role="main" class="container" style="display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; min-height: 100vh;">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Login</h1>
            </div>
        </div>
    </div>

<?php
	if ($_SESSION['account_created'] == 1) { ?>
			<span style="color: green">Account created! Please login.</span>
	<?php }
	
	// Unset variable so message doesn't stick around (eg when refreshing page)
	unset($_SESSION['account_created']);
	echo "\n\n";
?>

<div class="row">
    <div class="col-sm-auto">
		<form action="/login/verify" method="post" style="width: 300px">
		<fieldset>
			<div class="form-group" style="text-align: left">
				<label for="username">Username</label>
				<input required type="text" class="form-control" name="username">
			</div>
			<div class="form-group" style="text-align: left">
				<label for="password">Password</label>
				<input required type="password" class="form-control" name="password">
			</div>
			
			<?php // Display error messages
			if (isset($_SESSION['username_exists']) && ($_SESSION['username_exists'] == 0)) { ?>
					<span style="color: red">Username does not exist</span>
			 <?php }
			 if (isset($_SESSION['password_incorrect'])) { ?>
					<span style="color: red">Password is incorrect</span>
			<?php } 
				 unset($_SESSION['username_exists']);
				 unset($_SESSION['password_incorrect']); 
			?>
			<br>	
				 
			<button type="submit" class="btn btn-primary" 
				<?php 
				if (isset($_SESSION['locked']) && !(time() > $_SESSION['lock_end'])) { ?> disabled <?php } ?>>Login</button>
			<br>
		</fieldset>
		</form> 
	</div>
</div>
<a href="/create">Don't have an account? Sign up now.</a>

<?php
	if (isset($_SESSION['locked']) && !(time() > $_SESSION['lock_end'])) { ?>
		<br>
		<br>
		<div class="alert alert-danger" role="alert">
				You have been locked out for 60 seconds. Please refresh the page and try again later.
		</div>
	<?php }
	else {
		unset($_SESSION['locked']);
	}
?>
<br>
<?php require_once 'app/views/templates/footer.php' ?>
