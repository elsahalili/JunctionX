<?php
session_start();

$userEmail = $_SESSION['user']['email'] ?? 'guest@example.com';
$userFile = "users_data/" . $userEmail . ".json";

// Check if the user data exists
if (!file_exists($userFile)) {
    die('No user data found.');
}

$userData = json_decode(file_get_contents($userFile), true);
$faculties = [
    'Computer Science' => ['Tirana University' => 90, 'MIT' => 100, 'Oxford' => 85],
    'Medicine' => ['Harvard' => 95, 'Tirana University' => 75],
    'Business' => ['LSE' => 88, 'Tirana University' => 60],
];

$results = [];
if (isset($userData['cv_score']) && isset($userData['quiz_score'])) {
    foreach ($faculties as $faculty => $universities) {
        // Get CV and quiz scores, default to 0 if not found
        $cv = $userData['cv_score'][$faculty] ?? 0;
        $quiz = $userData['quiz_score'][$faculty] ?? 0;

        // Calculate the total score and ensure it does not exceed 100%
        $totalScore = min($cv + $quiz, 100); // Cap at 100%

        // Skip faculties with a total score of 0
        if ($totalScore == 0) {
            continue;
        }

        // Filter out universities with a score of 0
        $facultyResults = [];
        foreach ($universities as $uni => $percent) {
            if ($percent > 0) {
                $facultyResults[$uni] = $percent;
            }
        }

        // Only add faculties with non-zero universities
        if (!empty($facultyResults)) {
            $results[$faculty] = ['score' => $totalScore, 'universities' => $facultyResults];
        }
    }

    // Sort faculties by the total score (highest first)
    uasort($results, fn($a, $b) => $b['score'] <=> $a['score']);
} else {
    die('Incomplete data.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Match Results</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: flex-start; height: 100vh; flex-direction: column; padding: 20px; }
    .card-container { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; }
    .card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px #ccc; width: 280px; text-align: center; }
    .card h3 { color: #823341; margin-bottom: 15px; }
    .card p { font-size: 14px; color: #555; margin-bottom: 10px; }
    .card strong { font-size: 16px; color: #333; }
    .university-list { list-style: none; padding: 0; }
    .university-list li { margin-bottom: 5px; }
    button { padding: 10px 20px; background: #823341; color: white; border: none; border-radius: 5px; cursor: pointer; width: 100%; text-align: center; }
    button:hover { background: #b54c5f; }
  </style>
</head>
<body>

  <div>
    <h2>Matched Faculties and Universities</h2>

    <div class="card-container">
      <?php foreach ($results as $faculty => $data): ?>
        <div class="card">
          <h3><?= $faculty ?> (<?= $data['score'] ?>%)</h3>
          
          <p><strong>Top Universities:</strong></p>
          <ul class="university-list">
            <?php foreach ($data['universities'] as $uni => $percent): ?>
              <li>
                <button onclick="window.location.href='universityPage.php?name=<?= urlencode($uni) ?>'">
                  <?= $uni ?> - <?= $percent ?>%
                </button>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

</body>
</html>
