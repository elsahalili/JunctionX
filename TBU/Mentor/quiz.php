<?php
session_start();

$universities = [
    'Tirana University' => ['creative', 'social', 'organized'],
    'Tech Institute' => ['logical', 'technical', 'problem-solver'],
    'Business Academy' => ['organized', 'ambitious', 'social'],
];

$questions = [
    ['q' => 'Do you enjoy solving problems?', 'trait' => 'problem-solver'],
    ['q' => 'Are you more social or introverted?', 'trait' => 'social'],
    ['q' => 'Do you love being creative?', 'trait' => 'creative'],
    ['q' => 'Are you highly logical?', 'trait' => 'logical'],
    ['q' => 'Are you ambitious about your future?', 'trait' => 'ambitious'],
    ['q' => 'Do you like staying organized?', 'trait' => 'organized'],
    ['q' => 'Do you like technology?', 'trait' => 'technical'],
];

$total_questions = count($questions);

if (!isset($_SESSION['current'])) {
    $_SESSION['current'] = 0;
    $_SESSION['traits'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $answer = $_POST['answer'] ?? '';
    if ($answer === 'yes') {
        $trait = $questions[$_SESSION['current']]['trait'];
        $_SESSION['traits'][] = $trait;
    }
    $_SESSION['current']++;

    if ($_SESSION['current'] >= $total_questions) {
        $scores = [];
        foreach ($universities as $uni => $traits) {
            $matched = array_intersect($traits, $_SESSION['traits']);
            $percent = round((count($matched) / count($traits)) * 100);
            $scores[] = ['name' => $uni, 'percent' => $percent];
        }

        $userData = [
            'name' => 'Prototype Student',
            'email' => 'student@example.com',
            'matches' => $scores
        ];

        $allResults = json_decode(file_get_contents('results.json'), true) ?? [];
        $allResults[] = $userData;
        file_put_contents('results.json', json_encode($allResults, JSON_PRETTY_PRINT));

        header("Location: universityMatches.php");
        exit;
    }
}

$current_q = $_SESSION['current'];
$question = $questions[$current_q]['q'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background: #f8f8ff; }
        .quiz-box { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); text-align: center; width: 350px; }
        button { padding: 10px 20px; margin: 10px; border: none; border-radius: 8px; font-size: 16px; cursor: pointer; }
        .yes { background: #6c63ff; color: white; }
        .no { background: #ccc; }
    </style>
</head>
<body>

<div class="quiz-box">
    <h2>Question <?php echo $current_q + 1; ?> of <?php echo $total_questions; ?></h2>
    <p><?php echo $question; ?></p>
    <form method="post">
        <button name="answer" value="yes" class="yes">Yes</button>
        <button name="answer" value="no" class="no">No</button>
    </form>
</div>

</body>
</html>
