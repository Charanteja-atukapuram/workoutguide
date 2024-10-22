<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$exercises = [
    [
        "name" => "Overhead Press",
        "description" => "Strengthens the shoulders and triceps while engaging the core.",
        "gif" => "https://media1.tenor.com/m/vFJSvh8AvhAAAAAC/a1.gif"
    ],
    [
        "name" => "Lateral Raises",
        "description" => "Isolates the shoulders for improved width and definition.",
        "gif" => "https://media1.tenor.com/m/UsgJLQd7LLwAAAAC/good-morning.gif"
    ],
    [
        "name" => "Front Raises",
        "description" => "Targets the front deltoids for balanced shoulder development.",
        "gif" => "https://media1.tenor.com/m/cy46UbnfUrkAAAAC/eleva%C3%A7%C3%A3o-lateral-hateres.gif"
    ],
    [
        "name" => "Shrugs",
        "description" => "Strengthens the upper traps for better posture.",
        "gif" => "https://media1.tenor.com/m/U-KW3hhwhxcAAAAC/gym.gif"
    ],
    [
        "name" => "Dumbbell Flyes",
        "description" => "Opens up the chest and shoulders for increased flexibility.",
        "gif" => "https://media1.tenor.com/m/HTvjufujuJAAAAAC/rear-raise-rear.gif"
    ],
    [
        "name" => "Plank",
        "description" => "A core-strengthening exercise that engages multiple muscle groups.",
        "gif" => "https://media1.tenor.com/m/ckw_Fqaqml4AAAAC/exercise-planking.gif"
    ],
];

$quotes = [
    "Strength doesn't come from what you can do. It comes from overcoming the things you once thought you couldn't.",
    "The pain you feel today will be the strength you feel tomorrow.",
    "Push yourself, because no one else is going to do it for you.",
    "Success usually comes to those who are too busy to be looking for it.",
    "Don't stop when it hurts. Stop when you're done."
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Thursday's Workout</title>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Roboto', sans-serif;
        }
        .exercise {
            margin-bottom: 20px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .gif {
            display: block;
            margin: 10px auto;
            max-width: 70%;
            height: auto;
            border-radius: 10px;
        }
        .progress {
            height: 30px;
            margin: 20px 0;
        }
        .timer {
            font-size: 24px;
            margin: 20px 0;
        }
        .quote {
            background-color: #e8f0fe;
            border-left: 5px solid #007bff;
            padding: 15px;
            font-style: italic;
            font-size: 18px;
            color: #333;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thursday's Workout</h1>
        <div id="exercise-container" class="exercise"></div>
        <div class="timer" id="timer">30</div>
        <div class="progress">
            <div id="progress-bar" class="progress-bar progress-bar-success" role="progressbar" style="width: 100%;">
            </div>
        </div>
        <button id="skip-btn" class="btn btn-warning">Skip</button>
        <button id="start-btn" class="btn btn-success" style="margin-left: 10px;">Start</button>
        <div id="quote" class="quote" style="display: none;"></div>
    </div>

    <script>
        const exercises = <?php echo json_encode($exercises); ?>;
        const quotes = <?php echo json_encode($quotes); ?>;
        let currentExerciseIndex = 0;
        let timer;
        let timeLeft = 30;

        function showExercise() {
            if (currentExerciseIndex < exercises.length) {
                const exercise = exercises[currentExerciseIndex];
                document.getElementById('exercise-container').innerHTML = `
                    <h4>${exercise.name}</h4>
                    <p>${exercise.description}</p>
                    <img src="${exercise.gif}" alt="${exercise.name} GIF" class="gif">
                `;
                timeLeft = 30;
                document.getElementById('timer').innerText = timeLeft;
                document.getElementById('progress-bar').style.width = '100%';
                document.getElementById('progress-bar').className = 'progress-bar progress-bar-success';
                document.getElementById('quote').style.display = 'none';
            } else {
                document.getElementById('exercise-container').innerHTML = '<h4>Workout Completed!</h4>';
                document.getElementById('timer').style.display = 'none';
                document.getElementById('skip-btn').style.display = 'none';
                document.getElementById('start-btn').style.display = 'none';
            }
        }

        function startTimer() {
            clearInterval(timer);
            timer = setInterval(() => {
                timeLeft--;
                document.getElementById('timer').innerText = timeLeft;

                // Ensure the progress bar width is updated correctly
                const progressWidth = (timeLeft / 30) * 100;
                document.getElementById('progress-bar').style.width = `${progressWidth}%`;

                if (timeLeft <= 0) {
                    clearInterval(timer);
                    setTimeout(() => {
                        currentExerciseIndex++;
                        showRest();
                    }, 1000);
                }
            }, 1000);
        }

        function showRest() {
            const randomQuote = quotes[Math.floor(Math.random() * quotes.length)];
            document.getElementById('quote').innerText = randomQuote;
            document.getElementById('quote').style.display = 'block';

            timeLeft = 10;
            document.getElementById('timer').innerText = timeLeft;
            document.getElementById('exercise-container').innerHTML = '<h4>Rest Time!</h4>';
            document.getElementById('progress-bar').style.width = '100%';

            const restTimer = setInterval(() => {
                timeLeft--;
                document.getElementById('timer').innerText = timeLeft;

                // Update progress bar during rest
                const restProgressWidth = (timeLeft / 10) * 100;
                document.getElementById('progress-bar').style.width = `${restProgressWidth}%`;

                if (timeLeft <= 0) {
                    clearInterval(restTimer);
                    currentExerciseIndex++;
                    showExercise();
                }
            }, 1000);
        }

        document.getElementById('skip-btn').onclick = () => {
            clearInterval(timer);
            currentExerciseIndex++;
            showRest();
        };

        document.getElementById('start-btn').onclick = startTimer;

        window.onload = showExercise;
    </script>

    <script src="https://code.jquery.com/jquery-3.5.2.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
