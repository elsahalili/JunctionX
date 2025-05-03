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
    header("Location: profile.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Match Me to My Future</title>
  <style>
    body { font-family: Arial; background: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; flex-direction: column; }
    form, .card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px #ccc; margin-top: 20px; width: 100%; max-width: 400px; }
    button { padding: 10px 20px; background: #823341; color: white; border: none; border-radius: 5px; cursor: pointer; }
    button:hover { background: #b54c5f; }
    .card ul { padding: 0; list-style: none; }
    .card li { margin-bottom: 10px; }
  </style>
</head>
<body>

<?php if ($step === 'start'): ?>
  <form action="quizPage.php?step=upload" method="post" enctype="multipart/form-data">
    <h2>Step 1: Upload your CV</h2>
    <input type="file" name="cv" required><br><br>
    <button type="submit">Upload & Next</button>
  </form>

<?php elseif ($step === 'quiz'): ?>
  <form method="POST" action="quizPage.php?step=quiz">
    <h2>Step 2: Quiz</h2>
    <?php foreach ($quizQuestions as $question => $options): ?>
      <p><?= $question ?></p>
      <?php foreach ($options as $option): ?>
        <input type="radio" name="<?= md5($question) ?>" value="<?= $option ?>" required> <?= $option ?><br>
      <?php endforeach; ?>
      <br>
    <?php endforeach; ?>
    <button type="submit">Submit Quiz</button>
  </form>

<?php endif; ?>

<?php if ($message): ?>
  <p style="color:red"><?= $message ?></p>
<?php endif; ?>

</body>
</html>
