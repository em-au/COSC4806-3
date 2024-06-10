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
        <form action="/create/createUser" method="post" > <!-- need to change action -->
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
            <button type="submit" class="btn btn-primary">Sign up</button>
        </fieldset>
        </form> 
  </div>
</div>
<footer>
    <?php
    if (isset($_SESSION['username_exists']) && $_SESSION['username_exists'] == true) {
        echo "Username already taken";
    }

    // Unset variables so error messages don't persist (eg when refreshing the page)
    unset($_SESSION['username_exists']);
    ?>

</footer>
<br>
    
<?php require_once 'app/views/templates/footer.php' ?>
