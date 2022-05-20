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
require dirname(__FILE__) . "/includes/frontend/header.php";
require dirname(__FILE__) . "/includes/backend/appFunction.php";
require dirname(__FILE__) . "/includes/backend/SQLfunction.php";

logoutDrivers();
?>