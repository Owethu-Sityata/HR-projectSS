// Dummy login credentials
const credentials = {
    employee: { username: 'employee1', password: 'emp123' },
    admin: { username: 'admin', password: 'admin123' }
};

// Function to validate login
function validateLogin() {
    const username = document.getElementById('uname').value;
    const password = document.getElementById('pwd').value;
    const role = document.getElementById('role').value;

    let valid = false;

    // Logging to check if form inputs are correct
    console.log(`Username: ${username}, Password: ${password}, Role: ${role}`);

    if (role === 'employee' && username === credentials.employee.username && password === credentials.employee.password) {
        valid = true;
    } else if (role === 'admin' && username === credentials.admin.username && password === credentials.admin.password) {
        valid = true;
    }

    if (valid) {
        // Log the success and redirect
        console.log("Login successful. Redirecting...");
        window.location.href = 'index.html'; // Redirect to the main page
        return false; // Prevent the form from actually submitting and refreshing
    } else {
        // Log invalid login attempt
        console.log("Invalid login attempt");
        document.getElementById('error-modal').style.display = 'flex';
        return false; // Prevent form submission
    }
}

// Function to dismiss the error modal
function dismissModal() {
    document.getElementById('error-modal').style.display = 'none';
}
