<?php
session_start();

$quizFile = __DIR__ . '/../data/quiz_questions.json';
$quizQuestions = file_exists($quizFile) ? json_decode(file_get_contents($quizFile), true) : [];

$message = "";
$success = false;

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --main-color: #833442;
            --hover-color: #a14d5c;
        }

        body {
            background: #f9f9f9;
            font-family: 'Segoe UI', sans-serif;
            padding-top: 90px; /* offset for fixed navbar */
            animation: fadeInBody 0.8s ease-in-out;
        }

        @keyframes fadeInBody {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            animation: fadeInCard 0.7s ease-in-out;
        }

        @keyframes fadeInCard {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-add {
            background-color: var(--main-color);
            color: #fff;
            border: none;
            border-radius: 25px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-add:hover {
            background-color: var(--hover-color);
            box-shadow: 0 6px 14px rgba(131, 52, 66, 0.3);
            transform: translateY(-2px);
        }

        .btn-custom {
            background-color: var(--main-color);
            color: #fff;
            border-radius: 20px;
            padding: 6px 16px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-custom:hover {
            background-color: var(--hover-color);
            color: #fff;
            box-shadow: 0 4px 12px rgba(131, 52, 66, 0.3);
        }

        .list-group-item {
            border-radius: 10px;
            margin-bottom: 10px;
            background-color: #fff;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        }

        h2, h3 {
            color: var(--main-color);
        }
        :root {
      --main-color: #833442;
      --text-color: #333;
      --hover-color: #a14d5c;
    }

    .navbar {
      background-color: #fff;
    }

    .navbar-brand {
      color: var(--main-color) !important;
    }

    .navbar-nav .nav-link {
      color: var(--text-color);
      font-weight: 500;
      transition: color 0.3s;
    }

    .navbar-nav .nav-link:hover {
      color: var(--main-color);
    }

    .btn-custom {
      background-color: var(--main-color);
      color: #fff;
      border: none;
      transition: background-color 0.3s;
    }

    .btn-custom:hover {
      background-color: var(--hover-color);
      color: #fff;
    }

    @media (min-width: 992px) {
      .navbar-nav-center {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
      }
    }
    .btn-custom {
  background-color: #833442;
  color: #fff;
  border: none;
  padding: 0.5rem 1.2rem;
  border-radius: 30px;
  font-weight: 600;
  box-shadow: 0 4px 10px rgba(131, 52, 66, 0.3);
  transition: all 0.3s ease;
}

.btn-custom:hover {
  background-color: #a14d5c;
  box-shadow: 0 6px 14px rgba(131, 52, 66, 0.4);
  transform: translateY(-2px);
}
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
  <div class="container position-relative">
    <a class="navbar-brand fw-bold" style="color:#834773;" href="#">MyAdmin</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
      <ul class="navbar-nav navbar-nav-center">
        <li class="nav-item">
          <a class="nav-link text-dark" href="manage_universities.php">University</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="manage_users.php">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="quizzes.php">Quiz</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../manage_events.php">Events</a>
        </li>
      </ul>
    </div>

    <div class="d-none d-lg-block">
      <a class="btn btn-custom" href="../index.php">Back</a>
    </div>
  </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card p-4 mb-5 mt-3">
                <h2 class="mb-4">Add New Quiz Question</h2>

                <?php if ($message): ?>
                    <div class="alert alert-<?= $success ? 'success' : 'danger' ?> rounded-3">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="question" class="form-label">Question</label>
                        <input type="text" name="question" id="question" class="form-control" placeholder="Enter your question" required>
                    </div>

                    <label class="form-label">Options (minimum 2)</label>
                    <?php for ($i = 0; $i < 4; $i++): ?>
                        <input type="text" name="options[]" class="form-control mb-2" placeholder="Option <?= $i + 1 ?>">
                    <?php endfor; ?>

                    <button type="submit" class="btn btn-add mt-3">Add Question</button>
                </form>
            </div>

            <div class="card p-4">
                <h3 class="mb-3">Existing Questions</h3>

                <?php if (empty($quizQuestions)): ?>
                    <p class="text-muted">No questions added yet.</p>
                <?php else: ?>
                    <ul class="list-group">
                        <?php foreach ($quizQuestions as $q): ?>
                            <li class="list-group-item">
                                <strong><?= htmlspecialchars($q['question']) ?></strong>
                                <ul class="mt-2">
                                    <?php foreach ($q['options'] as $opt): ?>
                                        <li><?= htmlspecialchars($opt) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
