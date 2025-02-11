<?php
// Database connection
include_once 'db-inc.php'; 

// SQL query to fetch attendance records
$sql = "SELECT * FROM attendance";
$queryResult = mysqli_query($dbConnection, $sql);

if (!$queryResult) {
    die("Error in query execution: " . mysqli_error($dbConnection));
}

// Fetch all attendance records
$attendanceRecords = [];
while ($row = mysqli_fetch_assoc($queryResult)) {
    $attendanceRecords[] = $row;
}

// Handle form submissions for updating and deleting attendance records
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update attendance status
    if (isset($_POST['update_attendance'])) {
        $attendance_id = $_POST['attendance_id'];
        $status = $_POST['status'];

        // Update status in the database
        $updateSql = "UPDATE attendance SET status = '$status' WHERE attendance_id = '$attendance_id'";

        if (mysqli_query($dbConnection, $updateSql)) {
            echo "<script>alert('Attendance status updated successfully'); window.location.href='attendance.php';</script>";
        } else {
            echo "<script>alert('Error updating attendance: " . mysqli_error($dbConnection) . "');</script>";
        }
    }

    // Delete attendance record
    if (isset($_POST['delete_attendance_id'])) {
        $deleteAttendanceId = $_POST['delete_attendance_id'];
        $deleteSql = "DELETE FROM attendance WHERE attendance_id = '$deleteAttendanceId'";
        if (mysqli_query($dbConnection, $deleteSql)) {
            echo "<script>alert('Attendance record deleted successfully'); window.location.href='attendance.php';</script>";
        } else {
            echo "<script>alert('Error deleting attendance record: " . mysqli_error($dbConnection) . "');</script>";
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
    <title>Attendance Management</title>
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
        <h2>Attendance Records</h2>

        <!-- Attendance Records Table -->
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Attendance ID</th>
                    <th>Employee ID</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($attendanceRecords)): ?>
                    <?php foreach ($attendanceRecords as $attendance): ?>
                        <tr>
                            <td><?= htmlspecialchars($attendance["attendance_id"]) ?></td>
                            <td><?= htmlspecialchars($attendance["employee_id"]) ?></td>
                            <td><?= htmlspecialchars($attendance["date"]) ?></td>
                            <td><?= htmlspecialchars($attendance["status"]) ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="attendance_id" value="<?= $attendance['attendance_id'] ?>">
                                    <select name="status" class="form-select" required>
                                        <option value="Present" <?= $attendance['status'] == 'Present' ? 'selected' : '' ?>>Present</option>
                                        <option value="Absent" <?= $attendance['status'] == 'Absent' ? 'selected' : '' ?>>Absent</option>
                                        <option value="Leave" <?= $attendance['status'] == 'Leave' ? 'selected' : '' ?>>Leave</option>
                                    </select>
                                    <button type="submit" name="update_attendance" class="btn btn-warning btn-sm">Update</button>
                                </form>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_attendance_id" value="<?= $attendance['attendance_id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No attendance records found</td>
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
