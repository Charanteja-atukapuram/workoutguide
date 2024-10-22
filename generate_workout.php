<?php
    session_start();
    include 'db.php'; // Ensure this includes the database connection setup

    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
    }

    // Fetch user ID based on username
    $username = $_SESSION['username'];
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    // Function to log calories burned
    function logCaloriesBurned($conn, $user_id, $calories, $performance_metrics) {
        $date = date('Y-m-d');
        $insert_sql = "INSERT INTO progress (user_id, date, performance_metrics, calories_burned) VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("issi", $user_id, $date, $performance_metrics, $calories);
        $insert_stmt->execute();
        $insert_stmt->close();
    }

    // Define the total calories for the day
    $totalCalories = 300; // Total calories for the day
    $performanceMetrics = "Workout selected"; // You can change this based on the specific workout selected

    // Automatically log calories burned (assuming full workout is completed)
    $activityLevel = 1; // Assume the user completes the workout
    $caloriesBurned = (int)($totalCalories * $activityLevel);

    // Log the calories burned for the user
    logCaloriesBurned($conn, $user_id, $caloriesBurned, $performanceMetrics);

    // Redirect to the selected workout page
    if (isset($_GET['workout_type'])) {
        $workoutType = $_GET['workout_type'];
        switch ($workoutType) {
            case 'fat_loss':
                header("Location: fat_loss_workout.php");
                break;
            case 'muscle_gain':
                header("Location: muscle_gain.php");
                break;
            default:
                header("Location: generate_workout.php");
                break;
        }
        exit;
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
        <title>Generate Workout</title>
        <style>
            /* Your existing CSS styles */
            body {
                background-color: #f4f4f4;
                font-family: 'Roboto', sans-serif;
            }
            .container {
                margin-top: 50px;
                text-align: center;
            }
            h1 {
                margin-bottom: 40px;
                font-size: 2.5rem;
                color: #333;
                text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
            }
            .row {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                margin-bottom: 40px;
            }
            .category {
                flex: 0 0 30%;
                margin: 15px;
                transition: transform 0.3s, box-shadow 0.3s;
                border-radius: 10px;
                overflow: hidden;
                position: relative;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            }
            .category img {
                width: 100%;
                height: auto;
                transition: transform 0.3s;
            }
            .category:hover img {
                transform: scale(1.1);
            }
            .category-title {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(255, 255, 255, 0.8);
                padding: 10px;
                font-size: 1.5rem;
                color: #333;
                font-weight: bold;
                transition: background 0.3s;
            }
            .category:hover .category-title {
                background: rgba(255, 255, 255, 1);
            }
            .quote {
                margin-top: 60px;
                font-size: 1.5rem;
                font-style: italic;
                color: #333;
                max-width: 600px;
                margin-left: auto;
                margin-right: auto;
                background-color: #fff;
                padding: 20px;
                border-left: 5px solid #d1b57c;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                border-radius: 10px;
            }
            .quote-author {
                margin-top: 10px;
                font-size: 1.2rem;
                font-weight: bold;
                color: #d1b57c;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Choose Your Focus</h1>
            <div class="row">
                <div class="category">
                    <a href="?workout_type=fat_loss">
                        <img src="https://cbx-prod.b-cdn.net/COLOURBOX53200221.jpg?width=800&height=800&quality=70" alt="Fat Loss">
                        <div class="category-title">Fat Loss</div>
                    </a>
                </div>
                <div class="category">
                    <a href="?workout_type=muscle_gain">
                        <img src="https://clipground.com/images/clipart-six-pack-abs-6.jpg" alt="Muscle Gain">
                        <div class="category-title">Muscle Gain</div>
                    </a>
                </div>
            </div>

            <div class="quote">
                "Strength does not come from physical capacity. It comes from an indomitable will."
                <div class="quote-author">– Mahatma Gandhi</div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.2.slim.min.js"></script>
        <script src="cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>
