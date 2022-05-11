<?php
define('MY_CONSTANT', 1);

// Include config file
include(dirname(__FILE__) . "/../dbconf/settings.php");

// Initialize the session
session_start();

if (isset($_GET["q"]) && !empty($_GET["q"])) {
    $bookingRefNo = $_GET["q"];

    $update = "UPDATE passengers SET status = 'Assigned' WHERE bookingRefNo = '" . $bookingRefNo . "'";

    if ($conn->query($update) === true) {
        echo "Congratulations! Booking request '" . $bookingRefNo . "' has been assigned!";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
    $conn->close();
}
