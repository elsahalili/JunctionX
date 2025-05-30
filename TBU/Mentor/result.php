<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// STEP 1: Check session email
$userEmail = $_SESSION['user']['email'] ?? null;

if (!$userEmail) {
  echo '
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No Data</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body { margin: 0; height: 100vh; display: flex; justify-content: center; align-items: center; background: linear-gradient(to right, #f8f9fa, #e0e7ff); font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; }
      .card-redirect {
        background: #ffffff; border-radius: 1rem; box-shadow: 0 20px 35px rgba(0, 0, 0, 0.1); padding: 2.5rem; max-width: 420px;
        text-align: center; transition: all 0.3s ease-in-out; cursor: pointer;
      }
      .card-redirect:hover {
        transform: translateY(-5px) scale(1.02); box-shadow: 0 25px 40px rgba(0, 0, 0, 0.15);
      }
      .card-redirect h5 { font-size: 1.5rem; color: #2c3e50; margin-bottom: 0.75rem; }
      .card-redirect p { color: #6c757d; font-size: 1rem; }
    </style>
  </head>
  <body>
    <div class="card-redirect" onclick="window.location.href=\'quizPage.php\'">
      <h5>No Quiz Data Found</h5>
      <p>Please take the quiz to see your matched universities.</p>
    </div>
  </body>
  </html>';
  exit;
}

// STEP 2: Sanitize filename
$safeEmail = str_replace(['@', '.'], '_', $userEmail);
$userFile = "users_data/" . $safeEmail . ".json";

// STEP 3: Check if file exists
if (!file_exists($userFile)) {
  header("Location: quizPage.php");
  exit();
}

// STEP 4: Load and validate user data
$userData = json_decode(file_get_contents($userFile), true);

// Fallbacks
$quizScore = $userData['quiz_score'] ?? [];
$cvScore = $userData['cv_score'] ?? [];

// STEP 5: Faculty/University Matching
$faculties = [
  'Computer Science' => ['Tirana University' => 90, 'MIT' => 100, 'Oxford' => 85],
  'Medicine' => ['Harvard' => 95, 'Tirana University' => 75],
  'Business' => ['LSE' => 88, 'Tirana University' => 60],
];

$results = [];

foreach ($faculties as $faculty => $universities) {
  $cv = $cvScore[$faculty] ?? 0;
  $quiz = $quizScore[$faculty] ?? 0;
  $totalScore = min($cv + $quiz, 100);

  if ($totalScore == 0) continue;

  $facultyResults = [];
  foreach ($universities as $uni => $percent) {
    $facultyResults[$uni] = $percent;
  }

  if (!empty($facultyResults)) {
    $results[$faculty] = ['score' => $totalScore, 'universities' => $facultyResults];
  }
}

uasort($results, fn($a, $b) => $b['score'] <=> $a['score']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>UniMatch</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" />
  <style>
    body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; animation: fadeIn 1s ease-in; }
    @keyframes fadeIn { from {opacity: 0; transform: translateY(20px);} to {opacity: 1; transform: translateY(0);} }
    h2, h3.faculty-heading { text-align: center; color: #343a40; }
    .card { border: 1px solid #e0e0e0; border-radius: 10px; background-color: #ffffff; transition: 0.3s ease; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 12px 24px rgba(0,0,0,0.1); }
    .card-img-top { height: 200px; object-fit: cover; }
    .btn-custom { background-color: #823341; color: white; border-radius: 8px; padding: 10px 16px; }
    .btn-custom:hover { background-color: #b54c5f; color: white; }
    .meeting-btn {
      padding: 12px 28px; font-size: 1.2rem; font-weight: bold;
      color: #fff; background: linear-gradient(135deg, #823341, #a14a58);
      border-radius: 12px; text-decoration: none;
      transition: 0.3s ease; display: inline-block;
    }
    .meeting-btn:hover {
      background: linear-gradient(135deg, #a14a58, #823341); transform: translateY(-4px); color: white;
    }
  </style>
</head>
<body>

<header class="header d-flex align-items-center sticky-top mb-5">
  <div class="container-fluid container-xl d-flex justify-content-between align-items-center">
    <a href="index.html" class="logo"><h1 class="sitename">UniMatch</h1></a>
    <nav id="navmenu" class="navmenu">
      <ul class="m-0 d-flex gap-4">
        <li><a href="home.php">Home</a></li>
        <li><a href="result.php" class="active">Matched Universities</a></li>
        <li><a href="quizPage.php">Quiz</a></li>
      </ul>
    </nav>
    <div class="dropdown custom-dropdown">
      <a class="btn-getstarted dropdown-toggle" href="#" role="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-circle-user text-white me-2"></i>Profile
      </a>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
        <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
        <li><a class="dropdown-item" href="settings.php">Settings</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</header>

<div class="container">
  <h2 class="mb-4">Matched Faculties and Universities</h2>
  <div class="text-center mb-4">
    <a href="meeting.php" class="meeting-btn">MEETING</a>
  </div>

  <?php if (!empty($results)): ?>
    <?php foreach ($results as $faculty => $data): ?>
      <h3 class="faculty-heading mt-5" style="color:#673C26;">
        <?= htmlspecialchars($faculty) ?> (<?= $data['score'] ?>%)
      </h3>
      <div class="row g-4">
        <?php foreach ($data['universities'] as $uni => $percent): ?>
          <?php
            $imgName = strtolower(str_replace(' ', '_', $uni)) . '.jpg';
            $imgPath = "assets/img/universities/" . $imgName;
            if (!file_exists($imgPath)) {
              $imgPath = "assets/img/default_university.jpg";
            }
          ?>
          <div class="col-12 col-sm-6 col-lg-4">
            <div class="card h-100">
              <img src="<?= htmlspecialchars($imgPath) ?>" class="card-img-top" alt="<?= htmlspecialchars($uni) ?>">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= htmlspecialchars($uni) ?></h5>
                <p class="card-text"><strong>University Fit:</strong> <?= $percent ?>%</p>
                <a href="universityPage.php?name=<?= urlencode($uni) ?>" class="btn btn-custom mt-auto">View Details</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="alert alert-warning text-center">
      No matched results found. Please complete your quiz and CV evaluation.
    </div>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
