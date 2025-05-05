<?php
session_start();

// Make email safe for filenames
$userEmail = $_SESSION['user']['email'] ?? 'guest@example.com';
$safeEmail = str_replace(['@', '.'], '_', $userEmail);
$userFile = "users_data/" . $safeEmail . ".json";
$step = $_GET['step'] ?? 'start';
$message = "";

// Load quiz questions
$quizQuestions = [];
$quizPath = __DIR__ . "/admin_panel/data/quiz_questions.json";

if (file_exists($quizPath)) {
    $json = file_get_contents($quizPath);
    $data = json_decode($json, true);
    if (is_array($data)) {
        $quizQuestions = $data;
    } else {
        $message = "Invalid quiz format.";
    }
} else {
    $message = "Quiz file not found.";
}

// Initialize user file
if (!file_exists($userFile)) {
    file_put_contents($userFile, json_encode([]));
}
$userData = json_decode(file_get_contents($userFile), true);

// Handle CV upload
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
        $userData['cv_uploaded'] = true;
        file_put_contents($userFile, json_encode($userData));
        header("Location: quizPage.php?step=quiz");
        exit;
    } else {
        $message = "Upload a valid CV file.";
    }
}

// Handle quiz submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $step === 'quiz') {
    $score = ['Computer Science' => 0, 'Medicine' => 0, 'Business' => 0];

    foreach ($_POST as $key => $ans) {
        $ans = strtolower(trim($ans));

        if (in_array($ans, ['math', 'developer'])) {
            $score['Computer Science'] += 50;
        }
        if (in_array($ans, ['biology', 'doctor'])) {
            $score['Medicine'] += 50;
        }
        if (in_array($ans, ['economics', 'entrepreneur'])) {
            $score['Business'] += 50;
        }
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
  <title>UniMatch</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f0f2f5;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      flex-direction: column;
      padding: 15px;
      overflow-x: hidden;
      animation: fadeIn 1s ease-in;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    form, .card {
      background: white;
      padding: 30px 25px;
      border-radius: 12px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
      margin-top: 20px;
      width: 100%;
      max-width: 450px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      animation: popIn 0.5s ease;
    }

    @keyframes popIn {
      from { transform: scale(0.95); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }

    form > *, .card > * {
      margin-bottom: 15px;
    }

    button {
      padding: 12px 24px;
      background: #823341;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      width: 100%;
      max-width: 260px;
      transition: all 0.3s ease;
    }

    button:hover {
      background: #b54c5f;
      transform: scale(1.05);
    }

    .custom-file-upload {
      display: inline-block;
      padding: 12px 26px;
      cursor: pointer;
      border: 2px solid rgba(122, 119, 119, 0.1);
      border-radius: 25px;
      background-color: transparent;
      color: black;
      font-size: 16px;
      text-align: center;
      transition: all 0.3s ease;
      max-width: 250px;
    }

    .custom-file-upload:hover {
      background-color: rgba(122, 119, 119, 0.1);
      transform: scale(1.05);
    }

    input[type="file"] {
      display: none;
    }

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
      animation: fadeIn 0.5s ease-in-out;
    }

    label {
      display: block;
      margin: 8px 0;
      font-size: 15px;
      transition: transform 0.2s ease;
    }

    label:hover {
      transform: translateX(5px);
    }
  </style>
</head>
<body>

<?php if ($step === 'start'): ?>
  <form action="quizPage.php?step=upload" method="post" enctype="multipart/form-data">
    <h2>Step 1: Upload your CV</h2>
    <label for="cv" class="custom-file-upload"> Upload File </label>
    <input type="file" name="cv" id="cv" required>
    <p id="file-name" style="font-size: 14px; color: #555;"></p>
    <button type="submit">Upload & Next</button>
  </form>

<?php elseif ($step === 'quiz'): ?>
  <form method="POST" action="quizPage.php?step=quiz" id="quizForm">
    <h2>Quiz</h2>
    <?php $index = 0; foreach ($quizQuestions as $q): ?>
      <div class="quiz-card" style="<?= $index === 0 ? '' : 'display:none;' ?>">
        <p><strong><?= htmlspecialchars($q['question']) ?></strong></p>
        <?php foreach ($q['options'] as $option): ?>
          <label>
            <input type="radio" name="q<?= $index ?>" value="<?= htmlspecialchars($option) ?>" required> <?= htmlspecialchars($option) ?>
          </label>
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
  <p style="color:red; margin-top: 15px; font-weight: bold;"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<script>
  const fileInput = document.getElementById('cv');
  const fileNameDisplay = document.getElementById('file-name');

  fileInput?.addEventListener('change', function() {
    fileNameDisplay.textContent = fileInput.files.length > 0 ? "Selected file: " + fileInput.files[0].name : "";
  });

  const cards = document.querySelectorAll('.quiz-card');
  const nextButtons = document.querySelectorAll('.next-btn');

  nextButtons.forEach((btn, i) => {
    btn.addEventListener('click', () => {
      const selected = cards[i].querySelector('input[type="radio"]:checked');
      if (!selected) {
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
