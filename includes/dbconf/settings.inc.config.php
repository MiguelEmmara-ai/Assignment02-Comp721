<?php
$host = "db_host";
$user = "db_username";
$pswd = "db_password";
$dbnm = "db_name";

/*
|--------------------------------------------------------------------------
| Create Connection
|--------------------------------------------------------------------------
|
| Here are each of the database connections 
| setup for your application, simple mysqli connection setup make development simple.
| all the variable here will be changed to settings.php through installation script
|
*/

$conn = new mysqli($host, $user, $pswd, $dbnm);

// Check connection
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
