<?php
session_start();

$userEmail = $_SESSION['user']['email'] ?? null;

if (!$userEmail) {
    die('No user data found. Please take the quiz.');
}

$userFile = "users_data/" . $userEmail . ".json";

if (!file_exists($userFile)) {
    die('No user data found. Please take the quiz.');
}

$userData = json_decode(file_get_contents($userFile), true);

if (!isset($userData['cv_score']) || !isset($userData['quiz_score'])) {
    die('Incomplete data. Please take the quiz.');
}

$faculties = [
    'Computer Science' => ['Tirana University' => 90, 'MIT' => 100, 'Oxford' => 85],
    'Medicine' => ['Harvard' => 95, 'Tirana University' => 75],
    'Business' => ['LSE' => 88, 'Tirana University' => 60],
];

$results = [];

foreach ($faculties as $faculty => $universities) {
    $cv = $userData['cv_score'][$faculty] ?? 0;
    $quiz = $userData['quiz_score'][$faculty] ?? 0;
    $totalScore = min($cv + $quiz, 100);

    if ($totalScore == 0) {
        continue;
    }

    $facultyResults = [];
    foreach ($universities as $uni => $percent) {
        if ($percent > 0) {
            $facultyResults[$uni] = $percent;
        }
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
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Your Match Results</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    body {
      background-color: #f8f9fa;
      overflow-x: hidden;
      animation: fadeIn 1s ease-in;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h2, h3.faculty-heading {
      text-align: center;
      color: #343a40;
    }

    .card {
      border: 1px solid #e0e0e0;
      border-radius: 10px;
      overflow: hidden;
      background-color: #ffffff;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      text-align: left;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }

    .card-img-top {
      width: 100%;
      height: 200px;
      object-fit: cover;
      transition: opacity 0.3s ease;
    }

    .card-body {
      padding: 20px;
    }

    .card-title {
      font-size: 1.4rem;
      font-weight: 600;
      margin-bottom: 10px;
      color: #343a40;
    }

    .card-text {
      font-size: 1rem;
      color: #555;
      margin-bottom: 16px;
    }

    .btn-custom {
      background-color: #823341;
      color: white;
      padding: 10px 16px;
      border-radius: 8px;
      text-align: center;
      transition: background-color 0.3s ease;
    }

    .btn-custom:hover {
      background-color: #b54c5f;
      color: white;
    }

    #navmenu ul {
      display: flex;
      justify-content: center;
      gap: 30px;
      list-style: none;
      padding-left: 0;
      margin: 0;
    }

    #navmenu ul li a {
      font-weight: 500;
      padding: 8px 16px;
    }
  </style>
</head>
<body>
<header id="header" class="header d-flex align-items-center sticky-top mb-5">
  <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
    <a href="index.html" class="logo d-flex align-items-center">
      <h1 class="sitename">TBU</h1>
    </a>
    <nav id="navmenu" class="navmenu">
      <ul class="m-0">
      <li><a href="home.php">Home</a></li>
        <li><a href="result.php" class="active">Matched Universities</a></li>
        <li><a href="quizPage.php" >Quiz</a></li>
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
  <button>
    <a href="meeting.php">MEETING</a>
  </button>

  <?php foreach ($results as $faculty => $data): ?>
    <h3 class="faculty-heading mt-5"  style="color:#673C26;"><?= htmlspecialchars($faculty) ?> (<?= $data['score'] ?>%)</h3>
    <div class="row g-4">
      <?php foreach ($data['universities'] as $uni => $percent): ?>
        <?php
            $imgName = strtolower(str_replace(' ', '_', $uni)) . '.jpg';
            $imgPath = 'assets/img/universities/' . $imgName;
            if (!file_exists($imgPath)) {
                $imgPath = 'assets/img/default_university.jpg';
            }
        ?>
        <div class="col-12 col-sm-6 col-lg-4">
          <div class="card h-100">
            <img src="<?= htmlspecialchars($imgPath) ?>" class="card-img-top" alt="<?= htmlspecialchars($uni) ?> Image">
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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
