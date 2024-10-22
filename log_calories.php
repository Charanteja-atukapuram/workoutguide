<?php
session_start();
error_reporting(E_ALL); // Enable error reporting
ini_set('display_errors', 1); // Show errors on the browser

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session
    $calories_burned = intval($_POST['calories_burned']);
    $day = $_POST['day'];
    $time = $_POST['time'];
    $date = date('Y-m-d'); // Automatically get today's date

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "workout_generator");

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error); // Display error if connection fails
    }

    // Insert data into the progress table
    $sql = "INSERT INTO progress (user_id, calories_burned, date, time, day, performance_metrics) 
            VALUES ('$user_id', '$calories_burned', '$date', '$time', '$day', 'Workout completed')";

    if ($conn->query($sql) === TRUE) {
        echo "Calories logged successfully"; // Return success message
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; // Return error message
    }

    $conn->close();
}
