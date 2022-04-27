<!--Author: Muhamad Miguel Emmara-->
<!--Student ID: 18022146-->
<!--Email: ryf2144@autuni.ac.nz-->

<!--
    Description of File:
    logout drivers
-->

<?php
define('MY_CONSTANT', 1);

// Initialize the session
session_start();
$title = "Logging Out...";
include dirname(__FILE__)."/includes/frontend/header.php";
include dirname(__FILE__)."/includes/backend/appFunction.php";
include dirname(__FILE__)."/includes/backend/SQLfunction.php";

logoutDrivers();
?>