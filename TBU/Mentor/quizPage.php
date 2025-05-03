<?php
session_start();

$userEmail = $_SESSION['user']['email'] ?? 'guest@example.com';
$userFile = "users_data/" . $userEmail . ".json";
$step = $_GET['step'] ?? 'start';
$message = "";
$faculties = [
    'Computer Science' => ['Tirana University' => 90, 'MIT' => 100, 'Oxford' => 85],
    'Medicine' => ['Harvard' => 95, 'Tirana University' => 75],
    'Business' => ['LSE' => 88, 'Tirana University' => 60],
];
$quizQuestions = [
    'What subject do you enjoy most in school?' => ['Math', 'Biology', 'Economics'],
    'What career do you see yourself in?' => ['Developer', 'Doctor', 'Entrepreneur']
];

// Create user file if doesn't exist
if (!file_exists($userFile)) {
    file_put_contents($userFile, json_encode([]));
}
$userData = json_decode(file_get_contents($userFile), true);

// Handle CV Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $step === 'upload') {
    $cv = $_FILES['cv'] ?? null;
    if ($cv && $cv['tmp_name']) {
        $cvText = strtolower(file_get_contents($cv['tmp_name']));
        $profile = [
            'Computer Science' => (strpos($cvText, 'python') !== false || strpos($cvText, 'developer') !== false) ? 50 : 0,
            'Medicine' => (strpos($cvText, 'biology') !== false || strpos($cvText, 'health') !== false) ? 50 : 0,
            'Business' => (strpos($cvText, 'business') !== false || strpos($cvText, 'marketing') !== false) ? 50 : 0,
        ];
        $userData['cv_score'] = $profile;
        file_put_contents($userFile, json_encode($userData));
        header("Location: quizPage.php?step=quiz");
        exit;
    } else {
        $message = "Upload a valid CV file.";
    }
}

// Handle Quiz
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $step === 'quiz') {
    $answers = $_POST;
    $score = ['Computer Science' => 0, 'Medicine' => 0, 'Business' => 0];

    foreach ($answers as $q => $ans) {
        if ($ans === 'Math' || $ans === 'Developer') $score['Computer Science'] += 50;
        if ($ans === 'Biology' || $ans === 'Doctor') $score['Medicine'] += 50;
        if ($ans === 'Economics' || $ans === 'Entrepreneur') $score['Business'] += 50;
    }

    $userData['quiz_score'] = $score;
    file_put_contents($userFile, json_encode($userData));
    header("Location: result.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Match Me to My Future</title>
  <style>
    body {
  font-family: Arial;
  background: #f0f2f5;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  flex-direction: column;
  padding: 15px;
}

form, .card {
  background: white;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px #ccc;
  margin-top: 20px;
  width: 100%;
  max-width: 400px;

  /* Flexbox for inner content */
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
}

/* Make form/card elements spaced well */
form > *, .card > * {
  margin-bottom: 15px;
}

/* Button styling */
button {
  padding: 10px 20px;
  background: #823341;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  width: 100%;
  max-width: 250px;
}

button:hover {
  background: #b54c5f;
}

/* Styled file upload */
.custom-file-upload {
  display: inline-block;
  padding: 10px 25px;
  cursor: pointer;
  border: 2px solid rgba(122, 119, 119, 0.1);
  border-radius: 25px;
  background-color: transparent;
  color: black;
  font-size: 16px;
  text-align: center;
  transition: all 0.4s ease-in-out;
  max-width: 250px;
}

.custom-file-upload:hover {
  background-color: rgba(122, 119, 119, 0.1);
}

/* Hide the actual file input */
input[type="file"] {
  display: none;
}

/* Optional: Responsive typography or spacing if needed */
@media (max-width: 480px) {
  .custom-file-upload, button {
    font-size: 14px;
    padding: 10px 15px;
  }
}


.quiz-card {
  margin-top: 20px;
  width: 100%;
  max-width: 400px;
  text-align: left;
}


  </style>
</head>
<body>

<?php if ($step === 'start'): ?>
  <form action="quizPage.php?step=upload" method="post" enctype="multipart/form-data">
    <h2>Step 1: Upload your CV</h2>
    <label for="cv" class="custom-file-upload"> 
  Upload File
</label>
<input type="file" name="cv" id="cv" required>
<p id="file-name" style="font-size: 14px; color: #555;"></p>
<button type="submit">Upload & Next</button>
  </form>

  <?php elseif ($step === 'quiz'): ?>
  <form method="POST" action="quizPage.php?step=quiz" id="quizForm">
    <h2>Quiz</h2>

    <?php $index = 0; foreach ($quizQuestions as $question => $options): ?>
      <div class="quiz-card" style="<?= $index === 0 ? '' : 'display:none;' ?>">
        <p><strong><?= $question ?></strong></p>
        <?php foreach ($options as $option): ?>
          <label>
            <input type="radio" name="<?= md5($question) ?>" value="<?= $option ?>" required> <?= $option ?>
          </label><br>
        <?php endforeach; ?>
        <br>
        <?php if ($index < count($quizQuestions) - 1): ?>
          <button type="button" class="next-btn">Next</button>
        <?php else: ?>
          <button type="submit">Submit Quiz</button>
        <?php endif; ?>
      </div>
    <?php $index++; endforeach; ?>
  </form>
<?php endif; ?>


<?php if ($message): ?>
  <p style="color:red"><?= $message ?></p>
<?php endif; ?>




<script>
  const fileInput = document.getElementById('cv');
  const fileNameDisplay = document.getElementById('file-name');

  fileInput.addEventListener('change', function() {
    if (fileInput.files.length > 0) {
      fileNameDisplay.textContent = "Selected file: " + fileInput.files[0].name;
    } else {
      fileNameDisplay.textContent = "";
    }
  });
</script>

<script>
    const cards = document.querySelectorAll('.quiz-card');
    const nextButtons = document.querySelectorAll('.next-btn');

    nextButtons.forEach((btn, i) => {
      btn.addEventListener('click', () => {
        if (!cards[i].querySelector('input[type="radio"]:checked')) {
          alert("Please select an answer before continuing.");
          return;
        }
        cards[i].style.display = 'none';
        cards[i + 1].style.display = 'block';
      });
    });
  </script>
</body>
</html>
