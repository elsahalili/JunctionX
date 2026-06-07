<?php
require_once __DIR__ . '/../../app.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = app_read_json(__DIR__ . '/../data/admins.json', []);
    $email = trim($_POST["email"] ?? '');
    $password = $_POST["password"] ?? '';
    foreach ($data as $admin) {
        $storedPassword = $admin["password"] ?? '';
        $passwordMatches = str_starts_with($storedPassword, '$2y$')
            ? password_verify($password, $storedPassword)
            : hash_equals($storedPassword, $password);
        if (($admin["email"] ?? '') === $email && $passwordMatches) {
            $_SESSION["admin"] = $admin["email"];
            header("Location: ../index.php");
            exit();
        }
    }
    $error = "Invalid login credentials.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <style>
    @keyframes fadeUpIn {
      0%   { opacity: 0; transform: translateY(30px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    body {
      background: #f1f4f8;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    .login-card {
      width: 100%;
      max-width: 400px;
      background: white;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
      animation: fadeUpIn 0.8s ease-out both;
      text-align: center;
    }

    .login-card img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      margin-bottom: 20px;
    }

    .form-control {
      border: none;
      border-bottom: 2px solid #ccc;
      border-radius: 0;
      padding: 10px 10px;
      background: transparent;
      transition: border-color 0.3s;
      box-shadow: none;
    }

    .form-control:focus {
      border-color: #7a2e3c;
      box-shadow: none;
      background: transparent;
    }

    .btn-login {
      background-color: #2c3e50;
      color: #fff;
      font-weight: 600;
      border: none;
      border-radius: 50px;
      padding: 10px;
      width: 100%;
      transition: background-color 0.3s, transform 0.2s;
    }

    .btn-login:hover {
      background-color: #1a2533;
      transform: translateY(-2px);
    }

    .alert {
      text-align: left;
    }
  </style>
</head>
<body>
  <div class="login-card">
    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-light" style="width:80px;height:80px;">
      <span class="fw-bold fs-3 text-secondary">U</span>
    </div>
    <h3 class="mb-4">Admin Login</h3>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>" . app_h($error) . "</div>"; ?>
    <form method="post">
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="youremail@mail.com" required>
      </div>
      <div class="mb-4">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <button type="submit" class="btn btn-login">LOGIN</button>
    </form>
  </div>
</body>
</html>
