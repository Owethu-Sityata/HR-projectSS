<?php
//  database connection file
include_once 'db-inc.php'; 

// SQL query to fetch employee records
$sql = "SELECT * FROM employees"; 

// Executing the SQL query
$queryResult = mysqli_query($dbConnection, $sql);


if (!$queryResult) {
    die("Error in query execution: " . mysqli_error($dbConnection));
}

// Fetch all the employees' data
$employees = [];
while ($row = mysqli_fetch_assoc($queryResult)) {
    $employees[] = $row;
}

// Closing the database connection
mysqli_close($dbConnection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome | HR Management System</title>
    <link rel="stylesheet" href="/HR projectSS/styling/styles.css">
    <script defer src="/HR projectSS/script/splash.js"></script>
</head>
<body>
    <!-- Splash Screen Container -->
    <div id="splash-screen" class="splash-screen">
        <div class="content">
            <!-- Logo Image -->
            <img src="/HR projectSS/images/Moderntech Solutions.png" alt="Logo" class="logo-img">
            
            <!-- Animated Slogan -->
            <h1 class="slogan">Moderntech Solutions</h1><br>
            <h2>Solutions that care for Patients</h2>
            
            
            <!-- "Click to Continue" message -->
            <p id="click-message" class="click-message">Click anywhere to continue</p>
        </div>
    </div>
</body>
</html>
