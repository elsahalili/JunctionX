<?php
session_start();

$quizFile = __DIR__ . '/../data/quiz_questions.json';
$quizQuestions = file_exists($quizFile) ? json_decode(file_get_contents($quizFile), true) : [];

$message = "";
$success = false;

// Handle adding a new question
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['question'], $_POST['options'])) {
    $question = trim($_POST['question']);
    $options = array_map('trim', array_filter($_POST['options']));

    if ($question && count($options) >= 2) {
        $quizQuestions[] = [
            'question' => $question,
            'options' => $options
        ];
        if (file_put_contents($quizFile, json_encode($quizQuestions, JSON_PRETTY_PRINT))) {
            $success = true;
            $message = "Question added successfully.";
        } else {
            $message = "Failed to save the question.";
        }
    } else {
        $message = "Please enter a question and at least two options.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Quiz Questions</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Add New Quiz Question</h2>

    <?php if ($message): ?>
        <div class="alert alert-<?= $success ? 'success' : 'danger' ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="mb-5">
        <div class="mb-3">
            <label for="question" class="form-label">Question</label>
            <input type="text" name="question" id="question" class="form-control" required>
        </div>
        <label class="form-label">Options (minimum 2)</label>
        <?php for ($i = 0; $i < 4; $i++): ?>
            <input type="text" name="options[]" class="form-control mb-2" placeholder="Option <?= $i + 1 ?>">
        <?php endfor; ?>
        <button type="submit" class="btn btn-success">Add Question</button>
    </form>

    <h3>Existing Questions</h3>
    <?php if (empty($quizQuestions)): ?>
        <p>No questions added yet.</p>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($quizQuestions as $q): ?>
                <li class="list-group-item">
                    <strong><?= htmlspecialchars($q['question']) ?></strong>
                    <ul>
                        <?php foreach ($q['options'] as $opt): ?>
                            <li><?= htmlspecialchars($opt) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
</body>
</html>
