<?php
// Define database connection constants
define('DB_HOST', 'localhost');
define('DB_NAME', 'workout_generator');
define('DB_USER', 'root');
define('DB_PASS', '');

// Create a connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    // Log the error for debugging
    error_log("Connection failed: " . $conn->connect_error); // Log the error

    // Show a generic error message to the user
    die("Database connection failed. Please try again later."); // Generic error message
}

// Optional: Set charset to ensure correct character encoding
$conn->set_charset("utf8");

?>
