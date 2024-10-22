<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Database connection
include 'db.php';

// Fetch user details: ID, BMI, and first login status
$username = $_SESSION['username'];
$sql = "SELECT id, bmi, first_login FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($user_id, $bmi, $first_login);
$stmt->fetch();
$stmt->close();

// Handle BMI form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['height'], $_POST['weight'])) {
    // Convert height from feet to meters (1 foot = 0.3048 meters)
    $height = $_POST['height'] * 0.3048; // height in feet
    $weight = $_POST['weight']; // in kilograms

    // Calculate BMI
    $bmi = $weight / ($height * $height);

    // Update the user's BMI and mark first login as false
    $update_sql = "UPDATE users SET bmi = ?, first_login = FALSE WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("di", $bmi, $user_id);
    $update_stmt->execute();
    $update_stmt->close();

    // Reload the page to reflect the updated BMI
    header("Location: dashboard.php");
    exit;
}

// Function to determine BMI category
function getBMICategory($bmi) {
    if ($bmi < 18.5) {
        return "Underweight";
    } elseif ($bmi < 24.9) {
        return "Normal weight";
    } elseif ($bmi < 29.9) {
        return "Overweight";
    } else {
        return "Obese";
    }
}

$bmiCategory = '';
if (!$first_login) {
    $bmiCategory = getBMICategory($bmi);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <title>Dashboard</title>
    <style>
        body {
            background-color: #eef2f5;
            font-family: 'Roboto', sans-serif;
        }
        .navbar {
            background-color: #f8f4e3;
        }
        .navbar-brand {
            font-size: 1.5rem;
            color: #333;
        }
        .container {
            margin-top: 30px;
        }
        .welcome-message {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5rem;
            color: #333;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            background-color: #f1e7d8;
            color: #333;
            border-radius: 20px 20px 0 0;
            font-size: 1.25rem;
        }
        .btn-custom {
            background-color: #d1b57c;
            color: white;
            transition: background-color 0.3s;
        }
        .btn-custom:hover {
            background-color: #b89f6d;
        }
        .row {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="generate_workout.php">Generate Workout</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="view_progress.php">View Progress</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-message">
            <h1>Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>Your fitness journey starts here.</p>
        </div>

        <!-- Show BMI Calculator on First Login -->
        <?php if ($first_login): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Calculate Your BMI</div>
                        <div class="card-body">
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label for="height">Height (in feet):</label>
                                    <input type="number" step="0.01" class="form-control" name="height" required>
                                </div>
                                <div class="form-group">
                                    <label for="weight">Weight (in kilograms):</label>
                                    <input type="number" step="0.1" class="form-control" name="weight" required>
                                </div>
                                <button type="submit" class="btn btn-custom btn-block">Calculate BMI</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Display stored BMI after first login -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Your BMI</div>
                        <div class="card-body">
                            <p>Your Body Mass Index (BMI) is: <strong><?= htmlspecialchars(number_format($bmi, 2)); ?></strong></p>
                            <p>You are classified as: <strong><?= htmlspecialchars($bmiCategory); ?></strong></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Today's Workout</div>
                    <div class="card-body">
                        <p>Your personalized workout plan will be here!</p>
                        <a href="generate_workout.php" class="btn btn-custom btn-block">Create a Workout</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Progress Tracking</div>
                    <div class="card-body">
                        <p>Track your fitness progress and achievements!</p>
                        <a href="view_progress.php" class="btn btn-custom btn-block">View Progress</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Fitness Tips</div>
                    <div class="card-body">
                        <p>Get the latest tips and tricks to enhance your fitness journey!</p>
                        <a href="fitness_tips.php" class="btn btn-custom btn-block">Explore Tips</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
