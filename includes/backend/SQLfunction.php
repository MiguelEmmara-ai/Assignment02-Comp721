<?php
if (!defined('MY_CONSTANT')) {
    // You can show a message
    die('Access not allowed!');
    exit; // This line is needed to stop script execution
}

/**
 * Check for unique reference number in database.
 * using the input '$referenceNumber'
 * as key and search across database.
 */
function uniqueRefCheck($conn, $sql_table, $referenceNumber)
{
    $searchQuery = "SELECT * FROM $sql_table WHERE bookingRefNo = '$referenceNumber'";
    return mysqli_query($conn, $searchQuery)->num_rows === 0;
}

/**
 * Create Table Passengers If NotExist
 *
 * @author     Muhamad Miguel Emmara - 180221456 <ryf2144@autuni.ac.nz>
 */
function createTablePassengersIfNotExist()
{
    // Include config file
    require "includes/dbconf/settings.php";

    // Sql to create table If Not Exists
    $sql = "CREATE TABLE IF NOT EXISTS passengers(
        bookingRefNo VARCHAR(255) NOT NULL PRIMARY KEY,
        customerName TEXT NOT NULL,
        phoneNumber INT(12) NOT NULL,
        unitNumber TEXT,
        streetNumber TEXT NOT NULL,
        streetName TEXT NOT NULL,
        suburb TEXT,
        destinationSuburb TEXT,
        pickUpDate DATE NOT NULL,
        pickUpTime TIME NOT NULL,
        pickUpDateAndTime TIMESTAMP NOT NULL,
        status ENUM('Assigned','Unassigned') NOT NULL,
        carsNeed ENUM('Scooter','Hatchback','Suv','Sedan','Van') NOT NULL,
        assignedBy TEXT NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = latin1;";

    if ($conn->query($sql) === true) {
        // echo "Table post created successfully";
        // echo "<br>";
    } else {
        echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Error creating table!');
        </SCRIPT>");
        // echo "<br>";
    }

    // Close connection
    $conn->close();
}

/**
 * Create Table Drivers If NotExist
 *
 * @author     Muhamad Miguel Emmara - 180221456 <ryf2144@autuni.ac.nz>
 */
function createTableIfDriversNotExist()
{
    // Include config file
    require "includes/dbconf/settings.php";

    // Sql to create table If Not Exists
    $sql = "CREATE TABLE IF NOT EXISTS drivers (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        email VARCHAR(255) NOT NULL UNIQUE,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        carsAvailability VARCHAR(200) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
      ) ENGINE = InnoDB DEFAULT CHARSET = latin1;";

    if ($conn->query($sql) === true) {
        // echo "Table post created successfully";
        // echo "<br>";
    } else {
        echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Error creating table!');
        </SCRIPT>");
        // echo "<br>";
    }
}

/**
 * Add Passengers Booking To The Database
 *
 * @author     Muhamad Miguel Emmara - 180221456 <ryf2144@autuni.ac.nz>
 */
function addPassengers()
{
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
    global $pickUpDateAndTime;

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
    require "includes/dbconf/settings.php";

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

            // Concate Date And Time
            $pickUpDateAndTime = $pickUpDate + $pickUpTime;

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
        pickUpTime, pickUpDateAndTime, status, carsNeed, assignedBy
    )
    VALUES
        (
            '$referenceNumber', '$customerName',
            '$phoneNumber', '$unitNumber', '$streetNumber',
            '$streetName', '$suburb', '$destinationSuburb',
            '$pickUpDate', '$pickUpTime', '$pickUpDateAndTime', '$status', '$cars', '$assignedBy'
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
        pickUpTime, pickUpDateAndTime, status, carsNeed, assignedBy
)
VALUES
    (
        '$referenceNumber', '$customerName',
        '$phoneNumber', '$unitNumber', '$streetNumber',
        '$streetName', '$suburb', '$destinationSuburb',
        '$pickUpDate', '$pickUpTime', '$pickUpDateAndTime', '$status', '$cars', '$assignedBy'
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
}

/**
 * Login Drivers
 *
 * @author     Muhamad Miguel Emmara - 180221456 <ryf2144@autuni.ac.nz>
 */
function loginDrivers()
{
    // Include config file
    require "includes/dbconf/settings.php";

    // // Define variables and initialize with empty values
    // $username = $password = "";
    // $username_err = $password_err = $login_err = "";

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Check if username is empty
        if (empty(trim($_POST["username"]))) {
            $username_err = "Please enter username.";
        } else {
            $username = trim($_POST["username"]);
        }

        // Check if password is empty
        if (empty(trim($_POST["password"]))) {
            $password_err = "Please enter your password.";
        } else {
            $password = trim($_POST["password"]);
        }

        // Validate credentials
        if (empty($username_err) && empty($password_err)) {
            // Prepare a select statement
            $sql = "SELECT id, username, password FROM drivers WHERE username = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Bind variables to the prepared statement as parameters & to prevent SQL injection
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                // Set parameters
                $param_username = $username;

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Store result
                    mysqli_stmt_store_result($stmt);

                    // Check if username exists, if yes then verify password
                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        // Bind result variables
                        mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                        if (mysqli_stmt_fetch($stmt)) {
                            if (password_verify($password, $hashed_password)) {
                                // Password is correct, so start a new session
                                session_start();

                                // Store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;

                                // Redirect user to welcome page
                                header("location: admin.php");
                            } else {
                                // Password is not valid, display a generic error message
                                sweetAlertMsg("Oh No...", "Username Or Password is incorrect", "error", "Try Again");
                            }
                        }
                    } else {
                        // Username doesn't exist, display a generic error message
                        sweetAlertMsg("Oh No...", "Username Or Password is incorrect", "error", "Try Again");
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
        }

        // Close connection
        mysqli_close($conn);
    }
}

/**
 * Register Drivers
 *
 * @author     Muhamad Miguel Emmara - 180221456 <ryf2144@autuni.ac.nz>
 */
function registerDrivers()
{
    // Include config file
    require "includes/dbconf/settings.php";

    // Define variables and initialize with empty values
    global $email;
    global $username;
    global $password;
    global $confirm_password;
    global $email_err;
    global $username_err;
    global $password_err;
    global $confirm_password_err;

    $email = $username = $password = $confirm_password = $cars = "";
    $email_err = $username_err = $password_err = $confirm_password_err = "";

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Validate username
        if (empty(trim($_POST["username"]))) {
            $username_err = "Please enter a username.";
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
            $username_err = "Username can only contain letters, numbers, and underscores.";
        } else {

            // Prepare a select statement
            $sql = "SELECT id FROM drivers WHERE username = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Bind variables to the prepared statement as parameters & to prevent SQL injection
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                // Set parameters
                $param_username = trim($_POST["username"]);

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    /* store result */
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        $username_err = "This username is already taken.";
                    } else {
                        $username = trim($_POST["username"]);
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
        }

        // Validate email
        $email = trim($_POST["email"]);
        if (empty(trim($_POST["email"]))) {
            $email_err = "Please enter a valid email.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format";
        } else {
            $email = trim($_POST["email"]);
        }

        // Validate password
        if (empty(trim($_POST["password"]))) {
            $password_err = "Please enter a password.";
        } elseif (strlen(trim($_POST["password"])) < 6) {
            $password_err = "Password must have at least 6 characters.";
        } else {
            $password = trim($_POST["password"]);
        }

        // Validate confirm password
        if (empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = "Please confirm password.";
        } else {
            $confirm_password = trim($_POST["confirm_password"]);
            if (empty($password_err) && ($password != $confirm_password)) {
                $confirm_password_err = "Password did not match.";
            }
        }

        // Check input errors before inserting in database
        if (empty($username_err) && (empty($email_err) && empty($password_err) && empty($confirm_password_err))) {

            // Prepare an insert statement
            $sql = "INSERT INTO drivers (email, username, password, carsAvailability) VALUES (?, ?, ?, ?)";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Bind variables to the prepared statement as parameters & to prevent SQL injection
                mysqli_stmt_bind_param($stmt, "ssss", $param_email, $param_username, $param_password, $param_cars);

                // Set parameters
                $email = $_POST["email"];
                $param_email = $email;
                $param_username = $username;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

                // Array Permission Type For Cars
                $permissionList = [];
                foreach ($_POST["carsAvailabilityCheckBox"] as $check) {
                    array_push($permissionList, $check);
                }
                $_permissionTypeList = implode(", ", $permissionList);
                $param_cars = $_permissionTypeList;

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    sweetAlertMsgReturn("Welcome!", "You Are Successfully Registered!", "success", "OK", "login.php");
                } else {
                    sweetAlertMsg("Oh No...", "Error Occurred = $conn->error", "error", "OK");
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
        }

        // Close connection
        mysqli_close($conn);
    }
}

/**
 * Assign Booking Manual
 *
 * This Method used for assigning booking manual through user input
 * passing the bookingRefNo
 *
 * @author     Muhamad Miguel Emmara - 180221456 <ryf2144@autuni.ac.nz>
 * @param      $bookingRefNo
 */
function assignBookingManual($bookingRefNo)
{
    // Include config file
    require "includes/dbconf/settings.php";

    // Check if bookingRefNo input by user in the text box
    if (isset($_POST["booking"]) && !empty($_POST["booking"])) {
        $driver_name = $_SESSION["username"];
        $update = "UPDATE passengers SET status = 'Assigned',  assignedBy = '" . $driver_name . "' WHERE bookingRefNo = '" . $bookingRefNo . "'";

        $query = "SELECT * FROM passengers WHERE bookingRefNo = '$bookingRefNo'";

        if ($result = mysqli_query($conn, $query)) {
            // Return the number of rows in result set
            $rowcount1 = mysqli_num_rows($result);

            // Check if bookingRefNo exist - If Exist
            if ($rowcount1 > 0) {
                $query = "SELECT * FROM passengers WHERE bookingRefNo = '$bookingRefNo' AND status = 'Unassigned'";

                $result = mysqli_query($conn, $query);
                // Return the number of rows in result set
                $rowcount2 = mysqli_num_rows($result);

                // Check if bookingRefNo is Unassigned - If Unassigned
                if ($rowcount2 > 0) {
                    if ($conn->query($update) === true) {
                        // assigned bookingRefNo
                        sweetAlertMsgReturn("Congratulations!", "Booking request $bookingRefNo  \\nHas been assigned! For: $driver_name", "success", "OK!", "admin.php");
                    } else {
                        sweetAlertMsg("Oh No...", "Error Occurred = $conn->error", "error", "OK");
                    }
                    // Check if bookingRefNo is Unassigned - If Assigned
                } else {
                    sweetAlertMsg("Oh No...", "This Booking Number Reference has already been Assigned", "error", "OK");
                }
                // Check if bookingRefNo exist - If NOT Exist
            } else {
                sweetAlertMsg("Oh No...", "This Booking Number Reference Is Not Exist", "error", "OK");
            }
        }
    } else {
        // Check if bookingRefNo input by user in the text box
        sweetAlertMsg("Oh No...", "Please Fill The Booking Reference", "error", "OK");
    }

    // Close connection
    $conn->close();
}
