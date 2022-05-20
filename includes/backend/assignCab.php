<?php
define('MY_CONSTANT', 1);

// Include config file
include(dirname(__FILE__) . "/../dbconf/settings.php");

// Initialize the session
session_start();

if (isset($_GET["q"]) && !empty($_GET["q"])) {
    $bookingRefNo = $_GET["q"];
    $driver_name = $_SESSION["username"];

    $update = "UPDATE passengers SET status = 'Assigned',  assignedBy = '" . $driver_name . "' WHERE bookingRefNo = '" . $bookingRefNo . "'";

    if ($conn->query($update) === true) {
        echo "Booking request '" . $bookingRefNo . "' has been assigned! For '" . $driver_name . "'";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
    $conn->close();
}
