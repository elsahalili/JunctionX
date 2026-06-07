<?php
require_once __DIR__ . '/app.php';
session_start();

$error = "";
$success = "";

$usersFile = app_path('users.json');
$usersDataDir = app_path('users_data');

if (!is_dir($usersDataDir)) {
  mkdir($usersDataDir, 0755, true);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = trim($_POST["name"] ?? "");
  $surname = trim($_POST["surname"] ?? "");
  $email = trim($_POST["email"] ?? "");
  $password = $_POST["password"] ?? "";

  if ($name && $surname && filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($password) >= 8) {
    $users = app_read_json($usersFile, []);
    if (!is_array($users)) {
      $users = [];
    }

    foreach ($users as $user) {
      if (strcasecmp($user['email'] ?? '', $email) === 0) {
        $error = "Email already taken.";
        break;
      }
    }

    if (!$error) {
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $publicFile = app_public_user_file($email);
      $filename = app_path($publicFile);
    
      $users[] = [
        'name' => $name,
        'surname' => $surname,
        'email' => $email,
        'password' => $hashedPassword,
        'file' => $publicFile
      ];
    
      $personalData = [
        'name' => $name,
        'surname' => $surname,
        'email' => $email,
        'cv_uploaded' => false,
        'quiz_results' => [],
        'matched_faculties' => []
      ];
    
      app_write_json($usersFile, $users);
      app_write_json($filename, $personalData);

      $_SESSION['user'] = [
        'name' => $name,
        'surname' => $surname,
        'email' => $email,
        'file' => $publicFile
      ];
      $_SESSION['email'] = $email;
      app_redirect('home.php');
    }
    
    }
  } else {
    $error = "Please fill in all fields correctly. Password must be at least 8 characters.";
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up | UniMatch</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
  <style>
  body {
    background: linear-gradient(135deg, #fff7f2 0%, #f8f9fb 52%, #eef6f3 100%);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
  }

  .auth-card {
    width: min(100%, 430px);
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(55, 66, 59, 0.12);
  }

  .form-control {
    background: #f1f1f1;
    border: none;
    border-radius: 5px;
    padding: 14px;
    font-size: 14px;
    margin-bottom: 15px;
  }

  .btn-primary {
    background: #823341;
    border: none;
    padding: 12px;
    font-weight: bold;
    width: 100%;
    border-radius: 5px;
    font-size: 15px;
    transition:all 0.4s ease-in-out;
  }

  .btn-primary:hover {
    background: #b54c5f;
  }

  .alert {
    background-color: #ffe5e5;
    color: #b10000;
    padding: 10px;
    border-radius: 5px;
    font-size: 14px;
  }

  a {
    display: block;
    margin-top: 20px;
    text-decoration: none;
    font-weight: bold;
    color: black;
    padding: 12px;
    border-radius: 8px;
    transition:all 0.4s ease-in-out;
  }

  a:hover {
    background-color:#F1F1F1;
  }
  </style>
</head>
<body>
  <div class="auth-card">
    <a href="index.php" class="logo d-flex align-items-center justify-content-center mb-3">
      <span class="sitename fw-bold fs-3">UniMatch</span>
    </a>
    <h2 class="text-center mb-4">Sign Up</h2>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= app_h($error) ?></div>
    <?php endif; ?>
    <form method="POST">
      <input type="text" name="name" class="form-control" placeholder="Name" required>
      <input type="text" name="surname" class="form-control" placeholder="Surname" required>
      <input type="email" name="email" class="form-control" placeholder="Email" required>
      <input type="password" name="password" class="form-control" placeholder="Password" required>
      <button type="submit" class="btn btn-primary">Sign Up</button>
      <a href="login.php" class="text-center">Log In</a>
    </form>
  </div>
</body>
</html>
