<?php

// TODO

// Define variables and initialize with empty values
global $fName;
global $lName;
global $customerName;
global $phoneNumber;
global $unitNumber;
global $streetNumber;
global $streetName;
global $suburb;
global $destinationSuburb;
global $pickUpDate;
global $pickUpTime;

global $fName_err;
global $lName_err;
global $phoneNumber_err;
global $unitNumber_err;
global $streetNumber_err;
global $streetName_err;
global $suburb_err;
global $destinationSuburb_err;

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

// Include config file
// require_once("dbconf/settings.php");
require_once(dirname(__FILE__) . "/settings.php");

date_default_timezone_set('Pacific/Auckland');

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate fName
    if (empty(trim($_POST["fName"]))) {
        $fName_err = "Please enter a First Name.";
    } else {
        $fName = trim($_POST["fName"]);
    }

    // Validate lName
    if (empty(trim($_POST["lName"]))) {
        $lName_err = "Please enter a Last Name.";
    } else {
        $lName = trim($_POST["lName"]);
    }

    // Validate phoneNumber
    $phoneNumber = $_POST['phone'];
    if (empty(trim($_POST['phone']))) {
        $phoneNumber_err = "Please enter a valid phone number.";
    } else if (is_numeric($phoneNumber)) {
        $phoneNumber = $_POST['phone'];
    } else {
        $phoneNumber_err = "Please enter a valid phone number. (eg. 0221234567)";
    }

    // Validate unitNumber
    $unitNumber = $_POST['unumber'];
    if (empty(trim($_POST['unumber']))) {
        $unitNumber_err = "Please enter a valid Unit Number";
    } else if (is_numeric($unitNumber)) {
        $unitNumber = $_POST['unumber'];
    } else {
        $unitNumber_err = "Please enter a valid Unit Number (eg. 143)";
    }

    // Validate streetNumber
    $streetNumber = $_POST['snumber'];
    if (empty(trim($_POST['snumber']))) {
        $streetNumber_err = "Please enter a valid Street Number";
    } else if (is_numeric($streetNumber)) {
        $streetNumber = $_POST['snumber'];
    } else {
        $streetNumber_err = "Please enter a valid Street Number (eg. 61)";
    }

    // Validate streetName
    if (empty(trim($_POST["stname"]))) {
        $streetName_err = "Please enter a valid Street Name.";
    } else {
        $streetName = trim($_POST["stname"]);
    }

    // Validate suburb
    if (empty(trim($_POST["sbname"]))) {
        $suburb_err = "Please enter a valid Suburb.";
    } else {
        $suburb = trim($_POST["sbname"]);
    }

    // Validate destinationSuburb
    if (empty(trim($_POST["dsbname"]))) {
        $destinationSuburb_err = "Please enter a valid Destination Suburb.";
    } else {
        $destinationSuburb = trim($_POST["dsbname"]);
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
                    sweetAlertMsg("Thank you for your booking!", "Booking reference number: $referenceNumber \\nPickup time: $pickUpTime \\nPickup date: $pickUpDate", "success", "Aww yiss!");
                } else {
                    sweetAlertMsg("Oh No...", "Error Occurred = $conn->error", "error", "OK");
                }
            } else {
                sweetAlertMsg("Oh No...", "Error Occurred, please recheck your pick-up TIME", "error", "OK");
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
                sweetAlertMsg("Thank you for your booking!", "Booking reference number: $referenceNumber \\nPickup time: $pickUpTime \\nPickup date: $pickUpDate", "success", "Aww yiss!");
            } else {
                sweetAlertMsg("Oh No...", "Error Occurred = $conn->error", "error", "OK");
            }

            // else, date is too early
        } else {
            sweetAlertMsg("Oh No...", "Error Occurred, please recheck your pick-up DATE", "error", "OK");
        }
    } else {
        sweetAlertMsg("Going Somewhere?", "We Just Need A Little Bit More Info For Our Riders", "info", "OK");
    }

    // Close connection
    $conn->close();
}

/**
 * sweetAlertMsg
 * 
 * @param string   $title   The title of the popup, as HTML.
 * @param string   $text    A description for the popup. If text and html parameters are provided in the same time, html will be used.
 * @param string   $icon    The icon of the popup. SweetAlert2 comes with 5 built-in icon which will show a corresponding icon animation: warning, error, success, info, and question.
 * @param string   $btn    Button Text.
 * 
 * 
 * @author     Muhamad Miguel Emmara - 180221456 <ryf2144@autuni.ac.nz>
 */
function sweetAlertMsg($title, $text, $icon, $btn)
{
    echo '
    <script type="text/javascript">
    
    $(document).ready(function(){
    
        swal({
            html: true,
            title: "' . $title . '",
            text: "' . $text . '",
            icon: "' . $icon . '",
            button: "' . $btn . '",
        })
          });
    
    </script>
    ';
}

/**
 * sweetAlertMsgReturn
 * 
 * @param string   $title   The title of the popup, as HTML.
 * @param string   $text    A description for the popup. If text and html parameters are provided in the same time, html will be used.
 * @param string   $icon    The icon of the popup. SweetAlert2 comes with 5 built-in icon which will show a corresponding icon animation: warning, error, success, info, and question.
 * @param string   $btn    Button Text.
 * @param string   $return  Window Location href
 *  
 * 
 * @author     Muhamad Miguel Emmara - 180221456 <ryf2144@autuni.ac.nz>
 */
function sweetAlertMsgReturn($title, $text, $icon, $btn, $return)
{
    echo '
    <script type="text/javascript">
    
    $(document).ready(function(){
    
        swal({
            html: true,
            title: "' . $title . '",
            text: "' . $text . '",
            icon: "' . $icon . '",
            button: "' . $btn . '",
        }).then(function() {
            window.location.href = "' . $return . '";
        })
          });
    
    </script>
    ';
}
