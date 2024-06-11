<?php require_once 'app/views/templates/headerPublic.php'?>
<main role="main" class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Create an account</h1>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-sm-auto">
        <form action="/create/create_user" method="post" > <!-- need to change action -->
        <fieldset>
            <div class="form-group">
                <label for="username">Username</label>
                <input required type="text" class="form-control" name="username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input required type="password" class="form-control" name="password1">
            </div>
            <div class="form-group">
                <label for="password">Confirm Password</label>
                <input required type="password" class="form-control" name="password2">
              </div>
            <br>
            <button type="submit" class="btn btn-primary">Sign up</button>
            <br>
            <?php
            if (isset($_SESSION['username_exists']) && $_SESSION['username_exists'] == true) { ?>
                <br>
                <div class="alert alert-danger" role="alert">
                  Username already taken
                </div>
            <?php }
            else if (isset($_SESSION['password_mismatch']) && $_SESSION['password_mismatch'] == 1) { ?>
                <br>
                <div class="alert alert-danger" role="alert">
                    Passwords do not match
                </div>
              <?php }
              else if (isset($_SESSION['password_too_short']) && $_SESSION['password_too_short'] == 1) { ?>
                <br>
                <div class="alert alert-danger" role="alert">
                    Password must be at least 8 characters
                </div>
              <?php }

            // Unset variables so error messages don't persist (eg when refreshing page)
            unset($_SESSION['username_exists']);
            unset($_SESSION['password_mismatch']);
            unset($_SESSION['password_too_short']);
            ?>
            
        </fieldset>
        </form> 
  </div>
</div>
<footer>
    <a href="/login">Already have an account? Log in here.</a>
</footer>
<br>
    
<?php require_once 'app/views/templates/footer.php' ?>
    
