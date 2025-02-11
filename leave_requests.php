<?php
// Database connection
include_once 'db-inc.php'; 

// SQL query to fetch leave requests
$sql = "SELECT * FROM leave_requests";
$queryResult = mysqli_query($dbConnection, $sql);

if (!$queryResult) {
    die("Error in query execution: " . mysqli_error($dbConnection));
}

// Fetch all leave requests
$leaveRequests = [];
while ($row = mysqli_fetch_assoc($queryResult)) {
    $leaveRequests[] = $row;
}

// Handle form submissions for updating and deleting leave requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update leave request status
    if (isset($_POST['update_leave'])) {
        $request_id = $_POST['request_id'];
        $status = $_POST['status'];

        // Update status in the database
        $updateSql = "UPDATE leave_requests SET status = '$status' WHERE request_id = '$request_id'";

        if (mysqli_query($dbConnection, $updateSql)) {
            echo "<script>alert('Leave request updated successfully'); window.location.href='leave_requests.php';</script>";
        } else {
            echo "<script>alert('Error updating leave request: " . mysqli_error($dbConnection) . "');</script>";
        }
    }

    // Delete leave request
    if (isset($_POST['delete_leave_id'])) {
        $deleteLeaveId = $_POST['delete_leave_id'];
        $deleteSql = "DELETE FROM leave_requests WHERE request_id = '$deleteLeaveId'";
        if (mysqli_query($dbConnection, $deleteSql)) {
            echo "<script>alert('Leave request deleted successfully'); window.location.href='leave_requests.php';</script>";
        } else {
            echo "<script>alert('Error deleting leave request: " . mysqli_error($dbConnection) . "');</script>";
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
    <title>Leave Requests</title>
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
        <h2>Leave Requests</h2>

        <!-- Leave Requests Table -->
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Leave ID</th>
                    <th>Employee ID</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($leaveRequests)): ?>
                    <?php foreach ($leaveRequests as $leaveRequest): ?>
                        <tr>
                            <td><?= htmlspecialchars($leaveRequest["request_id"]) ?></td>
                            <td><?= htmlspecialchars($leaveRequest["employee_id"]) ?></td>
                            <td><?= htmlspecialchars($leaveRequest["leave_type"]) ?></td>
                            <td><?= htmlspecialchars($leaveRequest["start_date"]) ?></td>
                            <td><?= htmlspecialchars($leaveRequest["end_date"]) ?></td>
                            <td><?= htmlspecialchars($leaveRequest["status"]) ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="request_id" value="<?= $leaveRequest['request_id'] ?>">
                                    <select name="status" class="form-select" required>
                                        <option value="Pending" <?= $leaveRequest['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="Approved" <?= $leaveRequest['status'] == 'Approved' ? 'selected' : '' ?>>Approved</option>
                                        <option value="Rejected" <?= $leaveRequest['status'] == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                                    </select>
                                    <button type="submit" name="update_leave" class="btn btn-warning btn-sm">Update</button>
                                </form>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_leave_id" value="<?= $leaveRequest['request_id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No leave requests found</td>
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
