<?php
session_start();

$error = "";
$usersFile = "users.json";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = trim($_POST["email"] ?? "");
  $password = trim($_POST["password"] ?? "");

  if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password)) {
    if (file_exists($usersFile)) {
      $usersData = json_decode(file_get_contents($usersFile), true);

      foreach ($usersData as $user) {
        if ($user["email"] === $email) {
          if (password_verify($password, $user["password"])) {
            $_SESSION["user"] = [
              "name" => $user["name"],
              "email" => $user["email"]
            ];
            echo "<script>
              alert('Welcome back, {$user["name"]}!');
              window.location.href = 'index.html';
            </script>";
            exit();
          } else {
            $error = "Incorrect password.";
          }
          break;
        }
      }

      if (empty($error)) {
        $error = "No account found with that email.";
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
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f9f9f9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      max-width: 400px;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .form-control {
      margin-bottom: 15px;
    }

    .btn {
      width: 100%;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Login</h2>
    <?php if ($error): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
      <input type="email" name="email" class="form-control" placeholder="Email" required>
      <input type="password" name="password" class="form-control" placeholder="Password" required>
      <button class="btn btn-primary">Log In</button>
      <a href="register.php" class="d-block mt-3 text-center">Sign Up</a>
    </form>
  </div>
</body>
</html>
