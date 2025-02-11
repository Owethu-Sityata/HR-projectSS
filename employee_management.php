<?php
// Database connection file
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

// Handle form submissions for adding employees, deleting employees, and updating employee details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_employee'])) {
        // Add new employee
        $name = $_POST['name'];
        $position = $_POST['position'];
        $department = $_POST['department'];
        $salary = $_POST['salary'];
        $employment_history = $_POST['employment_history'];
        $contact = $_POST['contact'];

        // Get the latest employee ID and increment it
        $getMaxIdSql = "SELECT MAX(employee_id) AS last_id FROM employees";
        $result = mysqli_query($dbConnection, $getMaxIdSql);
        $lastId = mysqli_fetch_assoc($result)['last_id'];
        $newEmployeeId = $lastId + 1;

        $insertSql = "INSERT INTO employees (employee_id, name, position, department, salary, employment_history, contact) 
                      VALUES ('$newEmployeeId', '$name', '$position', '$department', '$salary', '$employment_history', '$contact')";
        if (mysqli_query($dbConnection, $insertSql)) {
            echo "<script>alert('New employee added successfully'); window.location.href='employee_management.php';</script>";
        } else {
            echo "<script>alert('Error adding employee: " . mysqli_error($dbConnection) . "');</script>";
        }
    }

    // Update employee details
    if (isset($_POST['update_employee'])) {
        $employee_id = $_POST['employee_id'];
        $name = $_POST['name'];
        $position = $_POST['position'];
        $department = $_POST['department'];
        $salary = $_POST['salary'];
        $employment_history = $_POST['employment_history'];
        $contact = $_POST['contact'];

        $updateSql = "UPDATE employees 
                      SET name = '$name', position = '$position', department = '$department', salary = '$salary', employment_history = '$employment_history', contact = '$contact'
                      WHERE employee_id = '$employee_id'";

        if (mysqli_query($dbConnection, $updateSql)) {
            echo "<script>alert('Employee updated successfully'); window.location.href='employee_management.php';</script>";
        } else {
            echo "<script>alert('Error updating employee: " . mysqli_error($dbConnection) . "');</script>";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_employee_id'])) {
    // Delete employee
    $deleteEmployeeId = $_POST['delete_employee_id'];
    $deleteSql = "DELETE FROM employees WHERE employee_id = '$deleteEmployeeId'";
    if (mysqli_query($dbConnection, $deleteSql)) {
        echo "<script>alert('Employee deleted successfully'); window.location.href='employee_management.php';</script>";
    } else {
        echo "<script>alert('Error deleting employee: " . mysqli_error($dbConnection) . "');</script>";
    }
}

// Closing the database connection
mysqli_close($dbConnection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
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
    <main class="container mt-5 pt-5">
        <section id="employee-management">
            <h2 class="mb-4">Employee Management</h2>
            <!-- Search Bar -->
            <div class="mb-3">
                <input type="text" id="search-input" class="form-control" placeholder="Search Employees" onkeyup="searchEmployee()">
            </div>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add New Employee</button>

            <!-- Employee Table -->
            <table class="table table-striped table-bordered" id="employee-table">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Salary</th>
                        <th>Employment History</th>
                        <th>Contact</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="employee-table-body">
                    <?php if (!empty($employees)): ?>
                        <?php foreach ($employees as $employee): ?>
                            <tr>
                                <td><?= htmlspecialchars($employee["employee_id"]) ?></td>
                                <td class="employee-name"><?= htmlspecialchars($employee["name"]) ?></td>
                                <td class="employee-position"><?= htmlspecialchars($employee["position"]) ?></td>
                                <td class="employee-department"><?= htmlspecialchars($employee["department"]) ?></td>
                                <td class="employee-salary"><?= htmlspecialchars($employee["salary"]) ?></td>
                                <td class="employee-history"><?= htmlspecialchars($employee["employment_history"]) ?></td>
                                <td class="employee-contact"><?= htmlspecialchars($employee["contact"]) ?></td>
                                <td>
                                    <a href="employee_management.php?edit_employee_id=<?= $employee['employee_id'] ?>" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editEmployeeModal">Edit</a>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="delete_employee_id" value="<?= $employee['employee_id'] ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">No employees found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <!-- Footer -->
    <footer class="text-center mt-5 p-3 bg-dark text-light">
        <p>&copy; 2024 Moderntech Solutions HR Management System. All rights reserved.</p>
    </footer>

    <!-- Add New Employee Modal -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEmployeeModalLabel">Add New Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="position" class="form-label">Position</label>
                            <input type="text" class="form-control" id="position" name="position" required>
                        </div>
                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" class="form-control" id="department" name="department" required>
                        </div>
                        <div class="mb-3">
                            <label for="salary" class="form-label">Salary</label>
                            <input type="number" class="form-control" id="salary" name="salary" required>
                        </div>
                        <div class="mb-3">
                            <label for="employment_history" class="form-label">Employment History</label>
                            <input type="text" class="form-control" id="employment_history" name="employment_history" required>
                        </div>
                        <div class="mb-3">
                            <label for="contact" class="form-label">Contact</label>
                            <input type="text" class="form-control" id="contact" name="contact" required>
                        </div>
                        <button type="submit" name="add_employee" class="btn btn-primary">Add Employee</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Employee Modal -->
    <div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEmployeeModalLabel">Edit Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- The content will be dynamically filled using JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to handle dynamic content for editing -->
    <script>
        // Function to handle search input
        function searchEmployee() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search-input");
            filter = input.value.toLowerCase();
            table = document.getElementById("employee-table");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                var found = false;

                for (var j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            found = true;
                        }
                    }
                }
                
                if (found) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }

        // Function to dynamically populate the edit modal
        document.addEventListener('DOMContentLoaded', function() {
            const editBtns = document.querySelectorAll('.btn-warning');
            editBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const row = btn.closest('tr');
                    const name = row.querySelector('.employee-name').textContent;
                    const position = row.querySelector('.employee-position').textContent;
                    const department = row.querySelector('.employee-department').textContent;
                    const salary = row.querySelector('.employee-salary').textContent;
                    const employment_history = row.querySelector('.employee-history').textContent;
                    const contact = row.querySelector('.employee-contact').textContent;

                    const modalBody = document.querySelector('#editEmployeeModal .modal-body');
                    modalBody.innerHTML = `
                        <form method="POST">
                            <input type="hidden" name="employee_id" value="${row.cells[0].textContent}">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="${name}" required>
                            </div>
                            <div class="mb-3">
                                <label for="position" class="form-label">Position</label>
                                <input type="text" class="form-control" id="position" name="position" value="${position}" required>
                            </div>
                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <input type="text" class="form-control" id="department" name="department" value="${department}" required>
                            </div>
                            <div class="mb-3">
                                <label for="salary" class="form-label">Salary</label>
                                <input type="number" class="form-control" id="salary" name="salary" value="${salary}" required>
                            </div>
                            <div class="mb-3">
                                <label for="employment_history" class="form-label">Employment History</label>
                                <input type="text" class="form-control" id="employment_history" name="employment_history" value="${employment_history}" required>
                            </div>
                            <div class="mb-3">
                                <label for="contact" class="form-label">Contact</label>
                                <input type="text" class="form-control" id="contact" name="contact" value="${contact}" required>
                            </div>
                            <button type="submit" name="update_employee" class="btn btn-primary">Update Employee</button>
                        </form>
                    `;
                });
            });
        });
    </script>
</body>
</html>
