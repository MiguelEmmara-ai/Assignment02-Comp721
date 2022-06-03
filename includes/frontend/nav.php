<?php

/*
|--------------------------------------------------------------------------
| Access Restriction
|--------------------------------------------------------------------------
|
| Here is the declaration that user or visitor
| can access the page
| all the (!defined('MY_CONSTANT')) meaning pages that CANNOT be access.
|
*/

if (!defined('MY_CONSTANT')) {
    // You can show a message
    die('Access not allowed!');
    exit;  // This line is needed to stop script execution
}
?>

<nav class="navbar navbar-dark navbar-expand-lg fixed-top bg-dark" id="mainNav">
    <div class="container"><a class="navbar-brand" href="index.php"><i class="fa fa-taxi"></i>&nbsp;Cabs Online</a><button data-bs-toggle="collapse" data-bs-target="#navbarResponsive" class="navbar-toggler navbar-toggler-right" type="button" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto text-uppercase">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">about</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#about">services</a></li>
                <li class="nav-item" style="margin-top: 10px;"><a class="btn btn-primary" role="button" style="background: rgba(10,9,8,0.27);" href="booking.html">Book A Ride</a></li>
                <li class="nav-item" style="margin-top: 10px;"><a class="btn btn-primary btn-book" role="button" href="register.php">Become A Driver</a></li>
                <li class="nav-item" style="margin-top: 10px;"><a class="btn btn-primary btn-login" role="button" href="login.php" style="background: rgb(99,168,231);">Login</a></li>
            </ul>
        </div>
    </div>
</nav>

