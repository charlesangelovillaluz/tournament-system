<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "sql112.infinityfree.com";
$user = "if0_41890453";
$pass = "xDa1LAJ9fd";
$db = "if0_41890453_tournament"; // CHANGE THIS to your real database name

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

?>