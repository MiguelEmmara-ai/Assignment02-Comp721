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
    exit; // This line is needed to stop script execution
}

/**
 * Check for unique reference number in database.
 * using the input '$referenceNumber'
 * as key and search across database.
 *
 * @param  mysqli  $conn
 * @param  string  $sql_table
 * @param  string  $referenceNumber
 * @return boolean
 *
 *
 * @author     Muhamad Miguel Emmara - 180221456 <ryf2144@autuni.ac.nz>
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
    require dirname(__FILE__) . "/settings.php";

    // Check if Table Exists
    $query = "SELECT * FROM passengers";
    $result = mysqli_query($conn, $query);

    if (empty($result)) {
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
            status ENUM('Assigned','Unassigned') NOT NULL,
            carsNeed ENUM('Scooter','Hatchback','Suv','Sedan','Van') NOT NULL,
            assignedBy TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE = InnoDB DEFAULT CHARSET = latin1;";

        if ($conn->query($sql) === true) {
            echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Table Passengers Created Successfully');
            </SCRIPT>");
        } else {
            echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Error creating table!');
            </SCRIPT>");
        }
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
    require dirname(__FILE__) . "/settings.php";

    // Check if Table Exists
    $query = "SELECT * FROM drivers";
    $result = mysqli_query($conn, $query);

    if (empty($result)) {
        // Sql to create table If Not Exists
        $sql = "CREATE TABLE IF NOT EXISTS drivers (
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            email VARCHAR(255) NOT NULL UNIQUE,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            carsAvailability VARCHAR(200) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
          ) ENGINE = InnoDB DEFAULT CHARSET = latin1;";

        if ($conn->query($sql) === true) {
            echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Table Driver Created Successfully');
            </SCRIPT>");
        } else {
            echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Error creating table!');
            </SCRIPT>");
        }
    }

    // Close connection
    $conn->close();
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
    require dirname(__FILE__) . "/settings.php";

    date_default_timezone_set('Pacific/Auckland');

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
}

/**
 * Login Drivers
 *
 * @author     Muhamad Miguel Emmara - 180221456 <ryf2144@autuni.ac.nz>
 */
function loginDrivers()
{
    // Include config file
    require dirname(__FILE__) . "/settings.php";

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Check if username is empty
        $usernameTrimmed = trim($_POST["username"]);
        if (empty($usernameTrimmed)) {
            $username_err = "Please enter username.";
        } else {
            $username = trim($_POST["username"]);
        }

        // Check if password is empty
        $passwordTrimmed = trim($_POST["password"]);
        if (empty($passwordTrimmed)) {
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
    require dirname(__FILE__) . "/settings.php";

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
        $usernameTrimmed = trim($_POST["username"]);
        if (empty($usernameTrimmed)) {
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

        /// I Commented this code because this code doesn't work on older version of php that AUT server use
        // // Validate email
        // $emailTrimmed = trim($_POST["email"]);
        // if (empty($emailTrimmed)) {
        //     $email_err = "Please enter a valid email.";
        // } elseif (!filter_var($email, FILTER_SANITIZE_EMAIL)) {
        //     $email_err = "Invalid email format";
        // } else {
        //     $email = trim($_POST["email"]);
        // }

        // Validate password
        $passwordTrimmed = trim($_POST["email"]);
        if (empty($passwordTrimmed)) {
            $password_err = "Please enter a password.";
        } elseif (strlen(trim($_POST["password"])) < 6) {
            $password_err = "Password must have at least 6 characters.";
        } else {
            $password = trim($_POST["password"]);
        }

        // Validate confirm password
        $passwordTrimmed = trim($_POST["confirm_password"]);
        if (empty($passwordTrimmed)) {
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
 * @param      $bookingRefNo
 *
 * @author     Muhamad Miguel Emmara - 180221456 <ryf2144@autuni.ac.nz>
 */
function assignBookingManual($bookingRefNo)
{
    // Include config file
    require dirname(__FILE__) . "/settings.php";

    // Check if bookingRefNo input by user in the text box
    if (isset($_POST["bsearch"]) && !empty($_POST["bsearch"])) {
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
