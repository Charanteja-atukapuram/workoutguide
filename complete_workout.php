<?php
session_start();
include 'db.php'; // Database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id']; // Get user ID from session

// Get the category dynamically (muscle gain or weight loss)
$category = isset($_POST['category']) ? $_POST['category'] : 'weight_loss'; // Assuming category is passed via POST

// Assume this is a calculation based on actual exercise performance
$total_calories = 1000; // Total calories for a full workout
$is_completed = isset($_POST['is_completed']) ? $_POST['is_completed'] == 'true' : false; // Use POST data for completion status

// Calculate calories burned
$calories_burned = $is_completed ? $total_calories : $total_calories * 0.5; // Burn half if incomplete

// Insert progress into the database
$sql = "INSERT INTO progress (user_id, category, calories_burned, date_time) VALUES (?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isi", $user_id, $category, $calories_burned);

if ($stmt->execute()) {
    echo "Progress recorded successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
