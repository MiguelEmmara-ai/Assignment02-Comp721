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
| Set Time Zone To New Zealand
|--------------------------------------------------------------------------
|
| Here we set default
| timezone for the server side to be in
| New Zealand.
|
*/

date_default_timezone_set('Pacific/Auckland');

/*
|--------------------------------------------------------------------------
| Require settings.php
|--------------------------------------------------------------------------
|
| include file
| settings.php
| for connect to database
|
*/

require dirname(__FILE__) . "/settings.php";

/*
|--------------------------------------------------------------------------
| Require appFunction
|--------------------------------------------------------------------------
|
| include file
| appFunction
| We'll require it so we can access the methods inside
|
*/

require dirname(__FILE__) . "/appFunction.php";

/*
|--------------------------------------------------------------------------
| Require SQLfunction
|--------------------------------------------------------------------------
|
| include file
| SQLfunction
| We'll require it so we can access the methods inside
|
*/

require dirname(__FILE__) . "/SQLfunction.php";

/*
|--------------------------------------------------------------------------
| createTablePassengersIfNotExist()
|--------------------------------------------------------------------------
|
| This Function Will
| create Table Passengers 
| If NotExist
|
*/

createTablePassengersIfNotExist();

// Define variables and initialize with empty values
$fName
    = $lName
    = $unitNumber
    = $phoneNumber
    = $streetNumber
    = $streetName
    = $suburb
    = $destinationSuburb
    = $cars = "";

$fName_err
    = $lName_err
    = $phoneNumber_err
    = $unitNumber_err
    = $streetNumber_err
    = $streetName_err
    = $suburb_err
    = $destinationSuburb_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate fName
    $fNameTrimmed = trim($_POST["fName"]);
    if (empty($fNameTrimmed)) {
        $fName_err = "Please enter a First Name.";
    } else {
        $fName = trim($_POST["fName"]);
    }

    // Validate lName
    $lNameTrimmed = trim($_POST["lName"]);
    if (empty($lNameTrimmed)) {
        $lName_err = "Please enter a Last Name.";
    } else {
        $lName = trim($_POST["lName"]);
    }

    // Validate phoneNumber
    $phoneNumberTrimmed = trim($_POST["phone"]);
    if (empty($phoneNumberTrimmed)) {
        $phoneNumber_err = "Please enter a valid phone number.";
    } else if (is_numeric($phoneNumberTrimmed)) {
        $phoneNumber = $_POST['phone'];
    } else {
        $phoneNumber_err = "Please enter a valid phone number. (eg. 0221234567)";
    }

    // Validate Unit Number (Optional)
    if (isset($_POST["unumber"])) {
        $unitNumber = $_POST["unumber"];
    } else if (!isset($_POST["unumber"])) {
        $unitNumberTrimmed = trim($_POST["unumber"]);
        if (empty($unitNumberTrimmed)) {
            $unitNumber_err = "Please enter a valid Unit Number";
        } else if (is_numeric($unitNumberTrimmed)) {
            $unitNumber = $_POST['unumber'];
        } else {
            $unitNumber_err = "Please enter a valid Unit Number (eg. 143)";
        }
    }

    // Validate streetNumber
    $streetNumberTrimmed = trim($_POST["snumber"]);
    if (empty($streetNumberTrimmed)) {
        $streetNumber_err = "Please enter a valid Street Number";
    } else if (is_numeric($streetNumberTrimmed)) {
        $streetNumber = $_POST['snumber'];
    } else {
        $streetNumber_err = "Please enter a valid Street Number (eg. 61)";
    }

    // Validate streetName
    $streetNameTrimmed = trim($_POST["stname"]);
    if (empty($streetNameTrimmed)) {
        $streetName_err = "Please enter a valid Street Name.";
    } else {
        $streetName = trim($_POST["stname"]);
    }

    // Validate suburb (Optional)
    if (isset($_POST["sbname"])) {
        $suburb = $_POST["sbname"];
    }

    // Validate destinationSuburb (Optional)
    if (isset($_POST["dsbname"])) {
        $destinationSuburb = $_POST["dsbname"];
    }

    // Check input errors before inserting in database
    if (empty($fName_err) && (empty($lName_err) && (empty($phoneNumber_err) && (empty($unitNumber_err) && (empty($streetNumber_err) && (empty($streetName_err) && (empty($suburb_err) && (empty($destinationSuburb_err))))))))) {

        $customerName = $fName . " " . $lName;
        $pickUpDate = $_POST['pickUpDate'];
        $pickUpTime = $_POST['pickUpTime'];
        $status = 'Unassigned';
        $cars = $_POST['inlineRadioOptions'];
        $assignedBy = 'None';

        // Generate a Unique reference number the first three characters are upper case “BRN”, then the rest five character are digits.
        $digits = 5;
        $referenceNumber = 'BRN' . str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
        $driver_name = $_SESSION["username"];

        $sql_table = "passengers";

        // Check if the reference number is unique in the database
        while (!uniqueRefCheck($conn, $sql_table, $referenceNumber)) {
            $referenceNumber = 'BRN' . str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
        }

        // Format date and time to MySQL DATETIME
        $pickUpDate = date('Y-m-d', strtotime($pickUpDate));
        $pickUpTime = date('H:i:s', strtotime($pickUpTime));

        // Date Validation
        $date1 = $pickUpDate;
        $date2 = date("Y-m-d");

        // If the date is the SAME as today, NEED to check for PICK-UP TIME
        if ($date1 == $date2) {

            // Time validation
            $time1 = $pickUpTime;
            $time2 = date('H:i:s', time());

            if ($time1 > $time2) {
                $sql = "INSERT INTO $sql_table (
    bookingRefNo, customerName, phoneNumber,
    unitNumber, streetNumber, streetName,
    suburb, destinationSuburb, pickUpDate,
    pickUpTime, status, carsNeed, assignedBy
)
VALUES
    (
        '$referenceNumber', '$customerName',
        '$phoneNumber', '$unitNumber', '$streetNumber',
        '$streetName', '$suburb', '$destinationSuburb',
        '$pickUpDate', '$pickUpTime', '$status', '$cars', '$assignedBy'
    )
";

                if ($conn->query($sql) === true) {
                    echo "Booking reference number: $referenceNumber <br> Pickup time: $pickUpTime <br> Pickup date: $pickUpDate";
                } else {
                    echo "Error Occurred = $conn->error";
                }
            } else {
                echo "Error Occurred, please recheck your pick-up TIME";
            }

            // If the date is NOT the same as today, NO NEED to check for PICK-UP TIME
        } else if ($date1 > $date2) {
            $sql = "INSERT INTO $sql_table (
bookingRefNo, customerName, phoneNumber,
unitNumber, streetNumber, streetName,
suburb, destinationSuburb, pickUpDate,
pickUpTime, status, carsNeed, assignedBy
)
VALUES
(
    '$referenceNumber', '$customerName',
    '$phoneNumber', '$unitNumber', '$streetNumber',
    '$streetName', '$suburb', '$destinationSuburb',
    '$pickUpDate', '$pickUpTime', '$status', '$cars', '$assignedBy'
)
";

            if ($conn->query($sql) === true) {
                echo "Booking reference number: $referenceNumber <br> Pickup time: $pickUpTime <br> Pickup date: $pickUpDate";
            } else {
                echo "Error Occurred = $conn->error";
            }
            // else, date is too early
        } else {
            echo "Error Occurred, please recheck your pick-up DATE";
        }
    } else {
        sweetAlertMsg("Going Somewhere?", "We Just Need A Little Bit More Info For Our Riders", "info", "OK");
    }

    // Close connection
    $conn->close();
}
