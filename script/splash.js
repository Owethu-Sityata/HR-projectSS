// Wait for the splash screen to load
window.onload = function () {
    // Wait for the user to click anywhere on the screen
    document.getElementById('splash-screen').addEventListener('click', function () {
        // Hide the splash screen
        document.getElementById('splash-screen').classList.add('hidden');
        // Redirect to login page after a short delay
        setTimeout(function () {
            window.location.href = 'login.html'; // Redirect to login page
        }, 500); // 500ms delay to allow splash screen to fade
    });
};
