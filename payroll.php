<?php
// Database connection
include_once 'db-inc.php'; 

// SQL query to fetch payroll records with employee names
$sql = "
    SELECT p.payroll_id, e.name, p.month, p.year, p.base_salary, p.bonuses, p.deductions, p.final_salary, p.payment_date
    FROM payroll p
    JOIN employees e ON p.employee_id = e.employee_id
";
$queryResult = mysqli_query($dbConnection, $sql);

if (!$queryResult) {
    die("Error in query execution: " . mysqli_error($dbConnection));
}

// Fetch all payroll records
$payrollRecords = [];
while ($row = mysqli_fetch_assoc($queryResult)) {
    $payrollRecords[] = $row;
}

// Handle form submissions for updating and deleting payroll records
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update payroll details
    if (isset($_POST['update_payroll'])) {
        $payroll_id = $_POST['payroll_id'];
        $base_salary = $_POST['base_salary'];
        $bonuses = $_POST['bonuses'];
        $deductions = $_POST['deductions'];
        $final_salary = $base_salary + $bonuses - $deductions;

        // Update payroll details in the database
        $updateSql = "
            UPDATE payroll 
            SET base_salary = '$base_salary', bonuses = '$bonuses', deductions = '$deductions', final_salary = '$final_salary' 
            WHERE payroll_id = '$payroll_id'
        ";

        if (mysqli_query($dbConnection, $updateSql)) {
            echo "<script>alert('Payroll updated successfully'); window.location.href='payroll.php';</script>";
        } else {
            echo "<script>alert('Error updating payroll: " . mysqli_error($dbConnection) . "');</script>";
        }
    }

    // Delete payroll record
    if (isset($_POST['delete_payroll_id'])) {
        $deletePayrollId = $_POST['delete_payroll_id'];
        $deleteSql = "DELETE FROM payroll WHERE payroll_id = '$deletePayrollId'";
        if (mysqli_query($dbConnection, $deleteSql)) {
            echo "<script>alert('Payroll record deleted successfully'); window.location.href='payroll.php';</script>";
        } else {
            echo "<script>alert('Error deleting payroll record: " . mysqli_error($dbConnection) . "');</script>";
        }
    }
}

// Close database connection
mysqli_close($dbConnection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
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

    <!-- Main Content Section -->
    <div class="container mt-5 pt-5">
        <h2>Payroll Records</h2>

        <!-- Payroll Table -->
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Payroll ID</th>
                    <th>Employee Name</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Base Salary</th>
                    <th>Bonuses</th>
                    <th>Deductions</th>
                    <th>Final Salary</th>
                    <th>Payment Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($payrollRecords)): ?>
                    <?php foreach ($payrollRecords as $payroll): ?>
                        <tr>
                            <td><?= htmlspecialchars($payroll["payroll_id"]) ?></td>
                            <td><?= htmlspecialchars($payroll["name"]) ?></td>
                            <td><?= htmlspecialchars($payroll["month"]) ?></td>
                            <td><?= htmlspecialchars($payroll["year"]) ?></td>
                            <td><?= htmlspecialchars($payroll["base_salary"]) ?></td>
                            <td><?= htmlspecialchars($payroll["bonuses"]) ?></td>
                            <td><?= htmlspecialchars($payroll["deductions"]) ?></td>
                            <td><?= htmlspecialchars($payroll["final_salary"]) ?></td>
                            <td><?= htmlspecialchars($payroll["payment_date"]) ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="payroll_id" value="<?= $payroll['payroll_id'] ?>">
                                    <input type="number" name="base_salary" value="<?= $payroll['base_salary'] ?>" class="form-control mb-2" required>
                                    <input type="number" name="bonuses" value="<?= $payroll['bonuses'] ?>" class="form-control mb-2" required>
                                    <input type="number" name="deductions" value="<?= $payroll['deductions'] ?>" class="form-control mb-2" required>
                                    <button type="submit" name="update_payroll" class="btn btn-warning btn-sm">Update</button>
                                </form>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_payroll_id" value="<?= $payroll['payroll_id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10">No payroll records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer Section -->
    <footer class="text-center mt-5 p-3 bg-dark text-light">
        <p>&copy; 2024 Moderntech Solutions HR Management System. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
