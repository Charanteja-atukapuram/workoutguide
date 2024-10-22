<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$exercises = [
    [
        "name" => " Jump Rope",
        "sets" => "30 seconds",
        "description" => "Warm-up exercise to get your heart rate up.",
        "gif" => "https://media1.tenor.com/m/cEYIOuth_3oAAAAd/jumping-rope-brandon-william.gif"
    ],
    [
        "name" => "High Knees ",
        "sets" => "12 reps",
        "description" => "Works the legs and glutes. Keep your back straight and engage your core.",
        "gif" => "https://media1.tenor.com/m/i4lmd-dNA5sAAAAC/knees.gif"
    ],
    [
        "name" => " Russian Twists",
        "sets" => "12 reps",
        "description" => "Strengthens chest, shoulders, and arms. Modify by doing knee push-ups if needed.",
        "gif" => "https://media1.tenor.com/m/Fmh1xemYphAAAAAd/dumbbellrussiantwists.gif"
    ],
    [
        "name" => "  Flutter Kicks ",
        "sets" => "1 minute",
        "description" => "Excellent cardio move that engages your core and gets your heart rate up.",
        "gif" => "https://media1.tenor.com/m/782xbt4rn4kAAAAC/mr-martinez-flutter-kicks.gif"
    ],
    
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Wednesday's Workout</title>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Roboto', sans-serif;
        }
        .timer {
            width: 100%;
            height: 30px;
            background: lightgrey;
            border-radius: 5px;
            position: relative;
            overflow: hidden;
            margin: 20px 0;
        }
        .progress-bar {
            height: 100%;
            background: #007bff;
            transition: width 1s linear;
        }
        .exercise, .rest {
            margin-bottom: 20px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .rest {
            background: #fff3cd; /* Light yellow for rest */
        }
        .gif {
            display: block;
            margin: 10px auto;
            max-width: 70%; /* Adjusted size */
            height: auto; /* Maintain aspect ratio */
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thursday's Workout</h1>
        <div id="exercises"></div>
    </div>

    <script>
        const exercises = <?php echo json_encode($exercises); ?>;
        const exerciseDuration = 30; // Default exercise duration in seconds
        const restDuration = 10; // Rest duration in seconds
        let currentExercise = 0;

        function showExercises() {
            if (currentExercise < exercises.length) {
                const exercise = exercises[currentExercise];
                const exerciseHtml = `
                    <div class="exercise">
                        <h4>${exercise.name} (${exercise.sets})</h4>
                        <p>${exercise.description}</p>
                        <img src="${exercise.gif}" alt="${exercise.name} GIF" class="gif">
                        <div class="timer" id="timer-${currentExercise}">
                            <div class="progress-bar" id="progress-${currentExercise}" style="width: 100%;"></div>
                        </div>
                        <button class="btn btn-primary" onclick="startTimer(${currentExercise})">Start</button>
                        <button class="btn btn-secondary" onclick="skipExercise()">Skip</button>
                    </div>
                `;
                document.getElementById('exercises').innerHTML = exerciseHtml;
            } else {
                document.getElementById('exercises').innerHTML = '<h2>Workout Complete!</h2>';
            }
        }

        function startTimer(index) {
            let time = exerciseDuration;
            const progressBar = document.getElementById(`progress-${index}`);
            progressBar.style.width = '100%';

            const interval = setInterval(() => {
                time--;
                progressBar.style.width = (time / exerciseDuration) * 100 + '%';
                if (time < 0) {
                    clearInterval(interval);
                    progressBar.style.width = '0%';
                    showRestTimer();
                }
            }, 1000);
        }

        function showRestTimer() {
            const restHtml = `
                <div class="rest">
                    <h4>Take Rest!</h4>
                    <div class="timer" id="rest-timer">
                        <div class="progress-bar" id="rest-progress" style="width: 100%;"></div>
                    </div>
                </div>
            `;
            document.getElementById('exercises').innerHTML += restHtml;
            startRest();
        }

        function startRest() {
            let time = restDuration;
            const restProgressBar = document.getElementById('rest-progress');
            restProgressBar.style.width = '100%';

            const restInterval = setInterval(() => {
                time--;
                restProgressBar.style.width = (time / restDuration) * 100 + '%';
                if (time < 0) {
                    clearInterval(restInterval);
                    restProgressBar.style.width = '0%';
                    currentExercise++;
                    showExercises(); // Show next exercise
                }
            }, 1000);
        }

        function skipExercise() {
            currentExercise++; // Skip current exercise
            showExercises(); // Show next exercise
        }

        // Show the first exercise when the page loads
        window.onload = showExercises;
    </script>

    <script src="https://code.jquery.com/jquery-3.5.2.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>