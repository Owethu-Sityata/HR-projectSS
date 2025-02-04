const suggestions = [
    "Sibongile Nkosi",
    "Lungile Moyo",
    "Thabo Molefe",
    "Keshav Naidoo",
    "Zanele Khumalo",
    "Sipho Zulu",
    "Naledi Moeketsi",
    "Farai Gumbo",
    "Karabo Dlamani",
    "Fatiman Patel"
];

function showSuggestions(value) {
    const suggestionBox = document.getElementById('suggestions');
    suggestionBox.innerHTML = '';
    if (value.length === 0) {
        return;
    }

    const filteredSuggestions = suggestions.filter(item => 
        item.toLowerCase().includes(value.toLowerCase())
    );

    filteredSuggestions.forEach(item => {
        const div = document.createElement('div');
        div.classList.add('suggestion-item');
        div.textContent = item;
        div.onclick = () => {
            document.getElementById('search-bar').value = item;
            suggestionBox.innerHTML = '';
        };
        suggestionBox.appendChild(div);
    });
}

// Sample employee data
let employees = [
    { id: 1, name: "Sibongile Nkosi", position: "Software Engineer", department: "Development", salary: "70000", employmentHistory: "Joined in 2015", contact: "sibongile.nkosi@moderntech.com" },
    { id: 2, name: "Juan", position: "Student", department: "Academy" },
    { id: 3, name: "Zenande", position: "Staff", department: "LC Studio" }
];

// Sample leave requests data
let leaveRequests = [
    { employeeId: 1, leaveType: "Sick", startDate: "2024-11-10", endDate: "2024-11-12", status: "Pending" },
    { employeeId: 2, leaveType: "Vacation", startDate: "2024-11-15", endDate: "2024-11-20", status: "Approved" }
];

// Dashboard stats
function updateDashboardStats() {
    // Total employees
    document.getElementById('total-employees').textContent = employees.length;

    // Pending leave requests
    const pendingLeaveRequests = leaveRequests.filter(request => request.status === 'Pending').length;
    document.getElementById('pending-leave-requests').textContent = pendingLeaveRequests;

    // Approved leave requests
    const approvedLeaveRequests = leaveRequests.filter(request => request.status === 'Approved').length;
    document.getElementById('approved-leave-requests').textContent = approvedLeaveRequests;
}

function addNewEmployee() {
    // Get input values from the user
    const newEmployee = {
        id: employees.length + 1,
        name: prompt("Enter employee name:"),
        position: prompt("Enter employee position:"),
        department: prompt("Enter employee department:"),
        salary: prompt("Enter employee salary:"),
        employmentHistory: prompt("Enter employee employment history:"),
        contact: prompt("Enter employee contact details:"),
    };

    // Add the new employee to the employees array
    employees.push(newEmployee);

    // Insert new table row
    let table = document.getElementById('employee-table-body');
    let row = table.insertRow(table.rows.length);

    row.innerHTML = `
        <td>${newEmployee.id}</td>
        <td>${newEmployee.name}</td>
        <td>${newEmployee.position}</td>
        <td>${newEmployee.department}</td>
        <td>${newEmployee.salary}</td>
        <td>${newEmployee.employmentHistory}</td>
        <td>${newEmployee.contact}</td>
        <td><button onclick="editEmployee(${newEmployee.id})">Edit</button></td>
    `;
}

//Function to render employee table
function renderEmployeeTable() {
    const employeeTableBody = document.getElementById('employee-table-body');
    employeeTableBody.innerHTML = ''; // Clear the table body first

    // Create a row for each employee
    employees.forEach(employee => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${employee.id}</td>
            <td>${employee.name}</td>
            <td>${employee.position}</td>
            <td>${employee.department}</td>
            <td>${employee.salary}</td>
            <td>${employee.employmentHistory}</td>
            <td>${employee.contact}</td>
            <td><button onclick="editEmployee(${employee.id})">Edit</button></td>
        `;
        employeeTableBody.appendChild(row);
    });
}

// Function to handle editing employee details
function editEmployee(employeeId) {
    const employee = employees.find(emp => emp.id === employeeId);
    if (employee) {
        alert(`Editing employee: ${employee.name}`);
        // Here you could open a form to edit employee details
    } else {
        console.error('Employee not found!');
    }
}

// Function to add a new employee (this could open a modal or prompt for input)
// function addEmployee() {
//     const newEmployee = {
//         id: employees.length + 1,
//         name: prompt("Enter employee name:"),
//         position: prompt("Enter employee position:"),
//         department: prompt("Enter employee department:"),
//         salary: prompt("Enter salary"),
//         employmentHistory: prompt("Enter employment history:"),
//         contact: prompt("Enter employee contact information:")
//     };
//     employees.push(newEmployee);
//     addEmployee()
//     //renderEmployeeTable(); // Re-render the employee table
//     updateDashboardStats()// Update dashboard stats
//}

// Function to render pending leave requests
function renderLeaveRequests() {
    const leaveTableBody = document.getElementById('leave-table-body');
    leaveTableBody.innerHTML = ''; // Clear the table body first

    leaveRequests.forEach(request => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${request.employeeId}</td>
            <td>${request.leaveType}</td>
            <td>${request.startDate}</td>
            <td>${request.endDate}</td>
            <td>${request.status}</td>
        `;
        leaveTableBody.appendChild(row);
    });
}

// Handle leave request submission (this function will be triggered by the form)
document.getElementById('leave-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the form from refreshing the page
    
    const leaveType = document.getElementById('leave-type').value;
    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;
    
    const newLeaveRequest = {
        employeeId: leaveRequests.length + 1, // Just a placeholder, you could tie this to actual employee IDs
        leaveType: leaveType,
        startDate: startDate,
        endDate: endDate,
        status: "Pending"
    };
    
    leaveRequests.push(newLeaveRequest); // Add to the leave requests array
    renderLeaveRequests(); // Re-render the leave requests table
    updateDashboardStats(); // Update dashboard stats
});

// Function to generate payroll (just a simple example, you can expand this as needed)
function generatePayroll() {
    const payrollTableBody = document.getElementById('payroll-table-body');
    payrollTableBody.innerHTML = ''; // Clear the table body first

    employees.forEach(employee => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${employee.id}</td>
            <td>${employee.name}</td>
            <td>R${(Math.random() * (6000 - 4000) + 4000).toFixed(2)}</td> <!-- Random salary for demo -->
            <td>Paid</td>
        `;
        payrollTableBody.appendChild(row);
    });
}

// Initial render when the page loads
renderEmployeeTable();
renderLeaveRequests();
updateDashboardStats();

//login functionality

// Handle the login validation
function validateLogin() {
    // Get username and password values
    const username = document.getElementById('uname').value;
    const password = document.getElementById('pwd').value;
  
    // Dummy login credentials (replace with real authentication logic, like checking a database)
    const validUsername = 'admin';
    const validPassword = 'password123';
  
    // Validate the credentials
    if (username === validUsername && password === validPassword) {
      // Redirect to the home page if login is successful
      window.location.href = 'home.html';  // Adjust the URL to match your home page
      return false; // Prevent form submission to avoid page reload
    } else {
      // Show the error modal if login fails
      document.getElementById('error-modal').style.display = 'block';
      return false; // Prevent form submission to stay on the login page
    }
  }
  
  // Function to dismiss the error modal
  function dismissModal() {
    document.getElementById('error-modal').style.display = 'none';
  }
  
  // leave section

  document.addEventListener('DOMContentLoaded', function () {
    // Sample data for the leave requests
    const employeeData = {
        "attendanceAndLeave": [
            {
                "employeeId": 1,
                "name": "Sibongile Nkosi",
                "leaveRequests": [
                    {
                        "date": "2024-12-01",
                        "reason": "Personal",
                        "status": "Pending"
                    }
                ]
            },
            {
                "employeeId": 2,
                "name": "Lungile Moyo",
                "leaveRequests": [
                    {
                        "date": "2024-11-22",
                        "reason": "Vacation",
                        "status": "Pending"
                    }
                ]
            },
            // Add more employees as needed...
        ]
    };

    const leaveTableBody = document.getElementById('leave-table-body');

    // Function to generate the table rows for pending leave requests
    function loadPendingLeaveRequests() {
        employeeData.attendanceAndLeave.forEach(employee => {
            employee.leaveRequests.forEach(leave => {
                if (leave.status === "Pending") {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${employee.name}</td>
                        <td>${leave.reason}</td>
                        <td>${leave.date}</td>
                        <td>${leave.date}</td>
                        <td>${leave.reason}</td>
                        <td>
                            <button class="btn btn-success" onclick="approveLeave(${employee.employeeId}, '${leave.date}')">Approve</button>
                            <button class="btn btn-danger" onclick="denyLeave(${employee.employeeId}, '${leave.date}')">Deny</button>
                        </td>
                    `;
                    leaveTableBody.appendChild(row);
                }
            });
        });
    }

    // Function to approve the leave request
    window.approveLeave = function(employeeId, leaveDate) {
        const employee = employeeData.attendanceAndLeave.find(e => e.employeeId === employeeId);
        const leave = employee.leaveRequests.find(l => l.date === leaveDate);

        if (leave && leave.status === "Pending") {
            leave.status = "Approved";
            alert(`Leave request for ${employee.name} on ${leaveDate} has been approved.`);
            updateLeaveTable();
        }
    };

    // Function to deny the leave request
    window.denyLeave = function(employeeId, leaveDate) {
        const employee = employeeData.attendanceAndLeave.find(e => e.employeeId === employeeId);
        const leave = employee.leaveRequests.find(l => l.date === leaveDate);

        if (leave && leave.status === "Pending") {
            leave.status = "Denied";
            alert(`Leave request for ${employee.name} on ${leaveDate} has been denied.`);
            updateLeaveTable();
        }
    };

    // Function to update the leave table after approval/denial
    function updateLeaveTable() {
        leaveTableBody.innerHTML = ''; // Clear the table body
        loadPendingLeaveRequests(); // Reload the updated table
    }

    // Load the initial pending leave requests when the page is loaded
    loadPendingLeaveRequests();
});


  
