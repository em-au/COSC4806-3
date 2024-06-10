<?php require_once 'app/views/templates/headerPublic.php'?>
<main role="main" class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Log in</h1>
            </div>
        </div>
    </div>

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
            <br>
		    <button type="submit" class="btn btn-primary">Login</button>
		</fieldset>
		</form> 
	</div>
</div>

<footer>
		<a href="/create">Don't have an account? Sign up now.</a>
		<?php
		if (isset($_SESSION['account_created']) && $_SESSION['account_created'] == 1) {
				echo "Account created! Please log in.";
		}

		// Unset variables so error messages don't persist (eg when refreshing page)
		unset($_SESSION['account_created']);
		?>
</footer>
<br>
	
<?php require_once 'app/views/templates/footer.php' ?>
