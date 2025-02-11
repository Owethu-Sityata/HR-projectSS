<?php
//  database connection file
include_once 'db-inc.php'; 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HR Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="/HR projectSS/script/script.js"></script>
</head>
<body>
    <!-- Navbar Section -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="/HR projectSS/images/Moderntech back2.png" alt="Moderntech Solutions" height="40" class="me-2">
                    <span>Moderntech Solutions</span>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="employee_management.php">Employee Management</a></li>
                        <li class="nav-item"><a class="nav-link" href="leave_requests.php">Leave Requests</a></li>
                        <li class="nav-item"><a class="nav-link" href="Attendance.php">Attendance</a></li>
                        <li class="nav-item"><a class="nav-link" href="payroll.php">Payroll</a></li>
                        <li class="nav-item"><a class="nav-link" href="perfomance.php">Performance Reviews</a></li>
                        <button id="logout-btn"><a href="login.php">Log Out</a></button> <!-- Log-out button -->
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <!-- Main Dashboard Section -->
        <section id="dashboard" class="container mt-5 pt-5">
            <h2>Welcome to the HR Dashboard</h2>
            <p>Here’s a quick summary of the current status in the HR system.</p>

            <!-- Dashboard Statistics Section -->
            <div id="dashboard-stats" class="row g-4">
                <!-- Employee Statistics (Bar Chart) -->
                <div class="col-md-6">
                    <div class="stat-box bg-light p-4 border rounded">
                        <h3>Employee Statistics</h3>
                        <!-- Bar chart for total employees, present, and absent -->
                        <canvas id="employeeStatsChart"></canvas>
                    </div>
                </div>
                
                <!-- Employee Attendance (Pie Chart) -->
                <div class="col-md-6">
                    <div class="stat-box bg-light p-4 border rounded">
                        <h3>Employee Attendance</h3>
                        <!-- Pie chart for employee attendance: Present vs Absent -->
                        <canvas id="attendanceChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Upcoming Birthdays Section -->
            <section id="upcoming-birthdays" class="mt-5">
                <h3>Upcoming Birthdays</h3>
                <ul id="birthday-list" class="list-group">
                    <li class="list-group-item">Thabo Molefe - January 25</li>
                    <li class="list-group-item">Naledi Moeketsi - February 10</li>
                    <li class="list-group-item">Fatiman Patel - March 5</li>
                    <!-- More birthdays can be dynamically generated here -->
                </ul>
            </section>

            <!-- Quick Links Section -->
            <section id="shortcuts" class="mt-5">
                <h3>Quick Links</h3>
                <div class="row g-4">
                    <div class="col-md-4">
                        <a href="employee_management.php" class="btn btn-primary w-100">Employee Management</a>
                    </div>
                    <div class="col-md-4">
                        <a href="leave_requests.php" class="btn btn-primary w-100">Leave Requests</a>
                    </div>
                    <div class="col-md-4">
                        <a href="payroll.php" class="btn btn-primary w-100">Payroll</a>
                    </div>
                </div>
            </section>
        </section>
    </main>

    <!-- Footer Section -->
    <footer class="text-center mt-5 p-3 bg-dark text-light">
        <p>&copy; 2024 Moderntech Solutions HR Management System. All rights reserved.</p>
    </footer>

    <script>
        // Data for the charts (example data)
        const totalEmployees = 250;
        const presentEmployees = 180;
        const absentEmployees = 70;

        // Employee Attendance Pie Chart Data
        const attendanceData = {
            labels: ['Present', 'Absent'],  // Labels for the pie chart
            datasets: [{
                data: [presentEmployees, absentEmployees], // Data for present and absent
                backgroundColor: ['#28a745', '#dc3545'], // Colors for present (green) and absent (red)
                hoverOffset: 4 // Adds a slight effect when hovering over the pie sections
            }]
        };

        // Pie chart configuration
        const attendanceConfig = {
            type: 'pie',
            data: attendanceData, // The data object defined above
        };

        // Employee Statistics Bar Chart Data
        const employeeStatsData = {
            labels: ['Total Employees', 'Present Employees', 'Absent Employees'], // Bar chart labels
            datasets: [{
                label: 'Employee Count', // Label for the dataset
                data: [totalEmployees, presentEmployees, absentEmployees], // Data points
                backgroundColor: ['#007bff', '#28a745', '#dc3545'], // Colors for each bar
                borderColor: ['#0056b3', '#218838', '#c82333'], // Border colors
                borderWidth: 1 // Width of the bar borders
            }]
        };

        // Bar chart configuration
        const employeeStatsConfig = {
            type: 'bar', // Specifies that this chart is a bar chart
            data: employeeStatsData, // The data object defined above
        };

        // Function to render the charts once the window is loaded
        window.onload = function() {
            // Initialize and render the Attendance Pie Chart
            const attendanceChart = new Chart(document.getElementById('attendanceChart'), attendanceConfig);
            // Initialize and render the Employee Statistics Bar Chart
            const employeeStatsChart = new Chart(document.getElementById('employeeStatsChart'), employeeStatsConfig);
        };
    </script>
</body>
</html>
