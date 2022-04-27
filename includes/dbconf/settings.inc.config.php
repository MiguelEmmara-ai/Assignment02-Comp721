<?php
$host="db_host";
$user="db_username";
$pswd="db_password";
$dbnm="db_name";

// Create connection
$conn = new mysqli($host, $user, $pswd, $dbnm);

// Check connection
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
?>