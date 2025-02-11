<?php


$servername = "localhost"; 
$username = "root"; 
$password = "";
$dbname = "moderntech_solutions"; 

// Database connection
$dbConnection = new mysqli('localhost', 'root', '', 'moderntech_solutions', 3307);

if ($dbConnection->connect_error) {
    die("Connection failed: " . $dbConnection->connect_error);
}

?>

