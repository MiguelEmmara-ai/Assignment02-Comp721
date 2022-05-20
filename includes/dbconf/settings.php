<?php
<<<<<<< HEAD
$host="localhost";
$user="root";
$pswd="";
$dbnm="cabsonline";

// Create connection
$conn = new mysqli($host, $user, $pswd, $dbnm);

// Check connection
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
?>
=======
$host = "localhost";
$user = "root";
$pswd = "";
$dbnm = "cabsonline";

/*
|--------------------------------------------------------------------------
| Create Connection
|--------------------------------------------------------------------------
|
| Here are each of the database connections 
| setup for your application.
| simple mysqli connection setup make development simple.
|
 */

$conn = new mysqli($host, $user, $pswd, $dbnm);

// Check connection 
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
>>>>>>> origin/dev/AutVersion
