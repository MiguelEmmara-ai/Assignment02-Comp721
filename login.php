<!--Author: Muhamad Miguel Emmara-->
<!--Student ID: 18022146-->
<!--Email: ryf2144@autuni.ac.nz-->

<!--
    Description of File:
    Login drivers, check if the drivers is on the system
-->

<!DOCTYPE html>
<html>

<?php

/*
|--------------------------------------------------------------------------
| Access Restriction
|--------------------------------------------------------------------------
|
| Here is the declaration that user or visitor
| can access the page
| all the define('MY_CONSTANT', 1) meaning pages that can be access.
|
 */

define('MY_CONSTANT', 1);

<<<<<<< HEAD
// Initialize the session
session_start();
$title = "Login Drivers | Cabs Online";
include dirname(__FILE__) . "/includes/frontend/header.php";
include dirname(__FILE__) . "/includes/backend/appFunction.php";
include dirname(__FILE__) . "/includes/backend/SQLfunction.php";
=======
/*
|--------------------------------------------------------------------------
| Initialize the session
|--------------------------------------------------------------------------
|
| creates a session or resumes the current one
| based on a session identifier passed via
| a GET or POST request, or passed via a cookie.
|
 */
>>>>>>> origin/dev/AutVersion

session_start();

/*
|--------------------------------------------------------------------------
| Title Variable
|--------------------------------------------------------------------------
|
| Title variable used to
| make dynamic title depending
| on the page where user are on.
|
 */

$title = "Login Drivers | Cabs Online";

/*
|--------------------------------------------------------------------------
| Require frontend/header
|--------------------------------------------------------------------------
|
| include file
| frontend/header
| for displaying the header
|
 */

require dirname(__FILE__) . "/includes/frontend/header.php";

/*
|--------------------------------------------------------------------------
| Require backend/appFunction
|--------------------------------------------------------------------------
|
| include file
| backend/appFunction
| We'll require it so we can access the methods inside
|
 */

require dirname(__FILE__) . "/includes/backend/appFunction.php";

/*
|--------------------------------------------------------------------------
| Require backend/SQLfunction
|--------------------------------------------------------------------------
|
| include file
| backend/SQLfunction
| We'll require it so we can access the methods inside
|
 */

require dirname(__FILE__) . "/includes/backend/SQLfunction.php";

/*
|--------------------------------------------------------------------------
| checkUserLoggedInRedirect()
|--------------------------------------------------------------------------
|
| Check if the user is already logged in,
| if yes then redirect
| the user to the admin page
|
 */
checkUserLoggedInRedirect();
?>
<?php include('includes/frontend/nav.php'); ?>

<<<<<<< HEAD
<!-- Start: Login Form Clean -->
<section class="login-clean" style="padding-top: 180px;">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <?php
        // Define variables and initialize with empty values
        $username = $password = "";
        $username_err = $password_err = $login_err = "";

        if (!empty($login_err)) {
            echo '<div class="alert alert-danger text-center">' . $login_err . '</div>';
        }
        ?>
        <div class="illustration">
            <h1 style="font-size: 30px;color: rgb(197,173,50);">Admin Login</h1><i class="la la-taxi" style="color: rgb(254,209,54);"></i>
        </div>
        <div class="mb-3">
            <input type="text" name="username" placeholder="Username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" required="">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
        </div>
        <div class="mb-3">
            <input type="password" name="password" placeholder="Password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" required="">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>
        <div class="mb-3">
            <button class="btn btn-primary d-block w-100" type="submit" style="background: rgb(254,209,54);">Log In</button>
        </div>
        <a class="already" href="register.php">You don't have an account yet? Register here.</a>
    </form>
</section>
<!-- End: Login Form Clean -->

<?php include('includes/frontend/footer.php'); ?>
=======
<body>
<?php

/*
|--------------------------------------------------------------------------
| Require frontend/nav
|--------------------------------------------------------------------------
|
| include file
| frontend/nav
| for displaying the navbar
|
 */

require "includes/frontend/nav.php";

?>

    <!-- Start: Login Form Clean -->
    <section class="login-clean" style="padding-top: 180px;">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <?php

/*
|--------------------------------------------------------------------------
| Define variables and initialize with empty values
|--------------------------------------------------------------------------
|
| Define variables and initialize
| with empty values
| this will use for the form initial values
|
 */

$username = $password = "";
$username_err = $password_err = $login_err = "";

// When the value of login_err is exist,
// we display the error message
// of whatever on the login_err variable is
if (!empty($login_err)) {
    echo '<div class="alert alert-danger text-center">' . $login_err . '</div>';
}
?>
            <div class="illustration">
                <h1 style="font-size: 30px;color: rgb(197,173,50);">Admin Login</h1><i class="la la-taxi" style="color: rgb(254,209,54);"></i>
            </div>
            <div class="mb-3">
                <input type="text" name="username" placeholder="Username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" required="">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="mb-3">
                <input type="password" name="password" placeholder="Password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" required="">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="mb-3">
                <button class="btn btn-primary d-block w-100" type="submit" style="background: rgb(254,209,54);">Log In</button>
            </div>
            <a class="already" href="register.php">You don't have an account yet? Register here.</a>
        </form>
    </section>
    <!-- End: Login Form Clean -->

    <?php

/*
|--------------------------------------------------------------------------
| Require frontend/footer
|--------------------------------------------------------------------------
|
| include file
| frontend/footer
| for displaying the footer
|
 */

require 'includes/frontend/footer.php';

?>
</body>

</html>
>>>>>>> origin/dev/AutVersion
