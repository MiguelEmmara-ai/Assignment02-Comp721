<!--Author: Muhamad Miguel Emmara-->
<!--Student ID: 18022146-->
<!--Email: ryf2144@autuni.ac.nz-->

<!--
    Description of File:
    This page is for drivers to create their new account
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

$title = "Register Driver | Cabs Online";

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
| Require backend/password
|--------------------------------------------------------------------------
|
| include file backend/password
| Since aut server use older version of php 5.4, I need https://github.com/ircmaxell/password_compat
| to use password functions supported in latest version of php
|
*/

require dirname(__FILE__) . "/includes/backend/password.php";

/*
|--------------------------------------------------------------------------
| createTableIfDriversNotExist()
|--------------------------------------------------------------------------
|
| This Function Will
| create Table Drivers
| If NotExist
|
*/

createTableIfDriversNotExist();

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

$email = $username = $password = $confirm_password = "";
$email_err = $username_err = $password_err = $confirm_password_err = "";

// When The signUp-button is clicked,
// we take the all input values
// and register the driver
if (isset($_POST['signUp-button'])) {

    /*
    |--------------------------------------------------------------------------
    | registerDrivers()
    |--------------------------------------------------------------------------
    |
    | This Function Will
    | Register Driver
    | Booking To The Database
    |
    */

    registerDrivers();
}

?>

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
    <!-- Start: Registration Form with Photo -->
    <section class="register-photo" style="margin-top: 60px;">
        <!-- Start: Form Container -->
        <div class="form-container">
            <!-- Start: Image -->
            <div class="image-holder"></div>
            <!-- End: Image -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <h2 class="text-center" style="margin-top: -18px;"><strong>Create</strong> an account.</h2>
                <p class="text-center" style="margin-top: 1px;">Partner with us to drive your own livelihood and more.<br></p>
                <div class="mb-3">
                    <input type="email" name="email" placeholder="Email" required="" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                    <span class="invalid-feedback"><?php echo $email_err; ?></span>
                </div>
                <div class="mb-3">
                    <input type="text" name="username" placeholder="Username" required="" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" placeholder="Password" required="" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="mb-3">
                    <input type="password" name="confirm_password" placeholder="Password (repeat)" required="" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="mb-3">
                    <p><strong>Select Car You Have</strong><br></p>

                    <div class="form-check form-check-inline">
                        <label>
                            <input class="form-check-input" type="checkbox" name="carsAvailabilityCheckBox[]" id="checkRadio1" value="Scooter">
                            <img src="./assets/img/cars/Scooter.png" alt="Car 1">
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label>
                            <input class="form-check-input" type="checkbox" name="carsAvailabilityCheckBox[]" id="checkRadio2" value="Hatch Back">
                            <img src="./assets/img/cars/Hatchback.png" alt="Car 2">
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label>
                            <input class="form-check-input" type="checkbox" name="carsAvailabilityCheckBox[]" id="checkRadio3" value="Suv">
                            <img src="./assets/img/cars/Suv.png" alt="Car 3">
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label>
                            <input class="form-check-input" type="checkbox" name="carsAvailabilityCheckBox[]" id="checkRadio4" value="Sedan">
                            <img src="./assets/img/cars/Sedan.png" alt="Car 4">
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label>
                            <input class="form-check-input" type="checkbox" name="carsAvailabilityCheckBox[]" id="checkRadio5" value="Van">
                            <img src="./assets/img/cars/Van.png" alt="Car 5">
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" required="">I agree to the license terms.</label>
                    </div>
                </div>
                <div class="mb-3">
                    <input class="btn btn-primary d-block w-100" type="submit" name="signUp-button" style="background: rgb(254,209,54);" value="Sign Up">
                </div>
                <a class="already" href="login.php">Don't have an account? Register here.</a>
            </form>
        </div>

        <!-- End: Form Container -->
    </section>
    <!-- End: Registration Form with Photo -->

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