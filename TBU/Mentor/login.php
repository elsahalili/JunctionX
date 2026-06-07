<?php
require_once __DIR__ . '/app.php';
session_start();

$error = "";
$usersFile = app_path('users.json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = trim($_POST["email"] ?? "");
  $password = $_POST["password"] ?? "";

  if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password)) {
    if (is_file($usersFile)) {
      $usersData = app_read_json($usersFile, []);

      if (!is_array($usersData)) {
        $error = "User data is corrupted or empty.";
      } else {
        foreach ($usersData as $user) {
          if (($user["email"] ?? '') === $email) {
            if (password_verify($password, $user["password"] ?? '')) {
              $_SESSION["user"] = [
                "name" => $user["name"],
                "surname" => $user["surname"] ?? "",
                "email" => $user["email"],
                "file" => $user["file"] ?? app_public_user_file($user["email"])
              ];
              $_SESSION["email"] = $user["email"];
              app_redirect('home.php');
            } else {
              $error = "Incorrect password.";
            }
            break;
          }
        }

        if (empty($error)) {
          $error = "No account found with that email.";
        }
      }
    } else {
      $error = "User data file not found.";
    }
  } else {
    $error = "Please enter a valid email and password.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | UniMatch</title>
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
    padding: 24px;
  }

  .auth-card {
    width: min(100%, 430px);
    background-color: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(55, 66, 59, 0.12);
    text-align: center;
  }

  .form-control {
    background-color: #f1f1f1;
    border: none;
    border-radius: 8px;
    padding: 14px;
    font-size: 14px;
    margin-bottom: 18px;
  }

  .btn-primary {
    background-color: #823341;
    border: none;
    padding: 12px;
    font-weight: bold;
    width: 100%;
    border-radius: 8px;
    font-size: 15px;
    transition:all 0.4s ease-in-out;
  }

  .btn-primary:hover {
    background-color: #b54c5f;
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
    <a href="index.php" class="logo d-inline-flex align-items-center justify-content-center mb-3">
      <span class="sitename fw-bold fs-3">UniMatch</span>
    </a>
    <h2>Login</h2>
    <?php if ($error): ?>
      <div class="alert alert-danger"><?= app_h($error) ?></div>
    <?php endif; ?>
    <form method="POST">
      <input type="email" name="email" class="form-control" placeholder="Email" required>
      <input type="password" name="password" class="form-control" placeholder="Password" required>
      <button class="btn btn-primary">Log In</button>
      <a href="register.php">Sign Up</a>
    </form>
  </div>
</body>
</html>
