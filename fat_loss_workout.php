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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Fat Loss Workout</title>
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
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5rem;
            color: #555;
        }
        .card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s, box-shadow 0.3s;
            margin: 10px;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .btn-day {
            width: 100%;
            border-radius: 10px;
            background-color: #6c757d;
            color: white;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn-day:hover {
            background-color: #5a6268;
        }
        .day-title {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Fat Loss Workout</h1>
        <h2>Select a Day:</h2>
        <div class="row">
            <?php 
            $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
            foreach ($days as $day): ?>
                <div class="col-md-4 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="day-title"><?= $day ?></div>
                            <a href="<?= strtolower($day) ?>.php" class="btn btn-day">Start Workout</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.2.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
