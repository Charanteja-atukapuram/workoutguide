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
    <title>Sunday Rest Day</title>
    <style>
        body {
            background-color: #e8f5e9; /* Light green for calmness */
            font-family: 'Arial', sans-serif;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 1.8rem;
            margin-top: 20px;
            color: #4caf50; /* Green for positive energy */
        }
        p {
            font-size: 1.1rem;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .image {
            margin: 20px 0;
        }
        .image img {
            max-width: 100%;
            border-radius: 15px;
        }
        .quote {
            font-style: italic;
            color: #555;
            margin-top: 20px;
        }
        .tips {
            margin-top: 30px;
            padding: 20px;
            background: #f1f8e9; /* Light yellow-green for tips */
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .tips h3 {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sunday: Rest Day</h1>
        <div class="image">
            <img src="https://media.tenor.com/5g2dG0Gy1FsAAAAi/rest-day.gif" alt="Rest Day Image">
        </div>
        <h2>Recharge and Relax</h2>
        <p>Today is all about recovery. Allow your body to rest and rejuvenate after a week of hard work. Take time to reflect and prepare for the upcoming week.</p>
        
        <div class="tips">
            <h3>Rest Day Tips:</h3>
            <ul>
                <li>Engage in light stretching or yoga.</li>
                <li>Stay hydrated and eat nutritious meals.</li>
                <li>Focus on mental wellness: meditate or read a book.</li>
                <li>Take a leisurely walk in nature.</li>
                <li>Catch up on sleep to aid recovery.</li>
            </ul>
        </div>
        
        <div class="quote">
            <p>"Take a rest; a field that has rested gives a bountiful crop." - Ovid</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.2.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
