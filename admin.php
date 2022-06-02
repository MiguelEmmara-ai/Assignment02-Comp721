<!--Author: Muhamad Miguel Emmara-->
<!--Student ID: 18022146-->
<!--Email: ryf2144@autuni.ac.nz-->
<!--
    Description of File:
    Admin page for drivers after login verification
-->

<!DOCTYPE html>
<html>

<?php

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

session_start();

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

$title = "Admin | Cabs Online";

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
| checkUserLoggedIn()
|--------------------------------------------------------------------------
|
| Check If User LoggedIn,
| if not then redirect
| the user to the login page
|
*/

checkUserLoggedIn();

// When The Assign OR Search is clicked,
// we take the variable booking and check
// if whether or not it is empty before we pass it to the method
if (isset($_POST['bsearch'])) {

    /*
    |--------------------------------------------------------------------------
    | assignBookingManual($bookingRefNo)
    |--------------------------------------------------------------------------
    |
    | Assign the booking
    | according to the bookingRefNo
    | and update the data
    |
    */

    assignBookingManual($_POST['bsearch']);
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
    <section>
        <!-- Start: Ludens - 1 Index Table with Search & Sort Filters  -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-6">
                    <h3 class="text-dark mb-4">Welcome Back, <?php echo $_SESSION["username"]; ?> </h3>
                </div>
                <div class="col-12 col-sm-6 col-md-6 text-end" style="margin-bottom: 30px;">
                    <a class="btn btn-primary mx-1 mb-2" role="button" onclick="showall()">
                        <i class="fa fa-plus"></i>&nbsp;Show All Bookings </a>
                        <a class="btn btn-primary mx-1 mb-2" role="button" onclick="showRecent()">
                        <i class="fa fa-plus"></i>&nbsp;Show Recent Bookings </a>
                    <a class="btn btn-primary mx-1 mb-2" role="button" onclick="showAvailPassengers()">
                        <i class="fa fa-plus"></i>&nbsp;Show All Available Bookings </a>
                    <a href="logout.php" class="btn btn-primary mb-2">Sign Out</a>
                </div>
            </div>
            <!-- Start: TableSorter -->
            <div class="card" id="TableSorterCard">
                <div class="card-header py-3">
                    <div class="row table-topper align-items-center justify-content-between">
                        <div class="col-md-4 text-start">
                            <p class="text-primary m-0 fw-bold">All Bookings</p>
                        </div>
                        <div class="col-md-2 py-2 text-end">
                            <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <div class="row g-3 align-items-center">
                                    <div class="col-auto">
                                        <input class="form-control mb-2" type="text" name="bsearch" id="bsearch" placeholder="Booking Number">
                                    </div>

                                    <div class="col-auto">
                                        <button class="btn btn-primary flex-fill py-2 mb-2" type="submit">
                                            <i class="far fa-paper-plane"></i> ASSIGN
                                        </button>

                                        <a class="btn btn-primary flex-fill py-2 mb-2" role="button" name="sbutton" id="sbutton" onclick="searchPassengers(bsearch.value)">
                                        <i class="fas fa-search"></i></i> Search </a>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <div id="tableID">
                                <b class="text-warning">Bookings info will be listed here.</b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End: TableSorter -->
        </div>
        <!-- End: Ludens - 1 Index Table with Search & Sort Filters  -->
    </section>

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