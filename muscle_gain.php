<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Muscle Gain Workout</title>
    <style>
        body {
            background-color: #eef2f3;
            font-family: 'Roboto', sans-serif;
            color: #333;
        }
        .container {
            margin-top: 50px;
            max-width: 1200px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5rem;
        }
        .card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s, box-shadow 0.3s;
            margin: 10px;
            background: linear-gradient(135deg, #f0f4f8, #c2c2c2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .btn-day {
            width: 100%;
            border-radius: 8px;
            background-color: #28a745;
            color: white;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn-day:hover {
            background-color: #218838;
        }
        .day-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Muscle Gain Workout</h1>
        <div class="row">
            <?php 
            $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
            foreach ($days as $day): ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="day-title"><?= $day ?></div>
                            <a href="muscle_<?= strtolower($day) ?>.php" class="btn btn-day">Start Workout</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
