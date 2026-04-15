<?php
date_default_timezone_set("Asia/Kolkata");

$host = "localhost";
$user = "root";
$password = "";
$database = "voting";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
?>