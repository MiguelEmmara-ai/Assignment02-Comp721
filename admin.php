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
// Initialize the session
session_start();

define('MY_CONSTANT', 1);
$title = "Admin | Cabs Online";
include dirname(__FILE__)."/includes/frontend/header.php";
include dirname(__FILE__)."/includes/backend/appFunction.php";
include dirname(__FILE__)."/includes/backend/SQLfunction.php";

checkUserLoggedIn();

if (isset($_POST['booking-brn-number'])) {
    assignBookingManual($_POST['booking-brn-number']);
}
?>

<body>
    <?php include "includes/frontend/nav.php"; ?>
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
                    <a class="btn btn-primary mx-1 mb-2" role="button" onclick="shoAvailPassengers()">
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
                        <div class="col-md-3 py-2 text-end">
                            <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <div class="row g-3 align-items-center">
                                    <div class="col-auto">
                                        <input class="form-control mb-2" type="text" name="booking-brn-number" placeholder="Booking Number">
                                    </div>
                                    <div class="col-auto">
                                        <button class="btn btn-primary flex-fill py-3" type="submit">
                                            <i class="far fa-paper-plane"></i> ASSIGN
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- <div class="col-12 col-sm-7 col-md-6 text-end" style="margin: 0px;padding: 5px 15px;">
                            <button class="btn btn-warning btn-sm" id="zoom_in" type="button" zoomclick="ChangeZoomLevel(-10);" style="margin: 2px;">
                                <i class="fa fa-search-plus"></i>
                            </button>
                            <button class="btn btn-warning btn-sm" id="zoom_out" type="button" zoomclick="ChangeZoomLevel(-10);" style="margin: 2px;">
                                <i class="fa fa-search-minus"></i>
                            </button>
                            <a href="logout.php" class="btn btn-primary btn-sm">Sign Out</a>
                        </div> -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <div id="txtHint">
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

    <?php include('includes/frontend/footer.php'); ?>
</body>

</html>