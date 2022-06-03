<!--Author: Muhamad Miguel Emmara-->
<!--Student ID: 18022146-->
<!--Email: ryf2144@autuni.ac.nz-->

<!--
    Description of File:
    About Cabs Online page
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

$title = "About Cabs Online";

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

require dirname(__FILE__) . "/includes/frontend/header.php"; ?>

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

    require 'includes/frontend/nav.php';
    ?>
    <!-- Start: Highlight Phone -->
    <section class="highlight-phone" style="background: rgb(254,251,240);height: 653px;padding-top: 113px;">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- Start: Intro -->
                    <div class="intro">
                        <h2>About us</h2>
                        <p style="color: rgb(0,0,0);"><strong><em>Trusted Cab Services in All World</em></strong><br></p>
                        <p>Cabs Online, The go-getters. We are a tech company that connects the physical and digital worlds to help make movement happen at the tap of a button. Because we believe in a world where movement should be accessible. So you can move and earn safely. In a way that’s sustainable for our planet. At Cabs Online, the pursuit of reimagination is never finished, never stops, and is always just beginning.</p>
                        <a class="btn btn-primary" role="button" href="booking.html" style="margin-left: -4px;background: rgb(59,59,59);">Book A RIDE</a>
                    </div><!-- End: Intro -->
                </div>
                <div class="col-sm-4">
                    <!-- Start: Smartphone -->
                    <div class="d-none d-md-block phone-mockup"><img class="device" src="assets/img/taxi-1.jpg">
                        <div class="screen"></div>
                    </div><!-- End: Smartphone -->
                </div>
            </div>
        </div>
    </section>
    <!-- End: Highlight Phone -->

    <!-- End: Highlight Phone -->
    <section data-aos="zoom-in" data-aos-duration="1150" data-aos-once="true" class="py-5">
        <h3 id="seen" class="text-center">As Seen On</h3>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-3"><a href="https://www.google.com/" target="_blank"><img class="img-fluid d-block mx-auto" src="assets/img/clients/google.jpg"></a></div>
                <div class="col-sm-6 col-md-3"><a href="https://www.facebook.com/" target="_blank"><img class="img-fluid d-block mx-auto" src="assets/img/clients/facebook.jpg"></a></div>
                <div class="col-sm-6 col-md-3"><a href="https://www.airbnb.co.nz/" target="_blank"><img class="img-fluid d-block mx-auto" src="assets/img/clients/airbnb.jpg"></a></div>
                <div class="col-sm-6 col-md-3"><a href="https://www.netflix.com/" target="_blank"><img class="img-fluid d-block mx-auto" src="assets/img/clients/netflix.jpg"></a></div>
            </div>
        </div>
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