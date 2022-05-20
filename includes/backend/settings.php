<?php
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