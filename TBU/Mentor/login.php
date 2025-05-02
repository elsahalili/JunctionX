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
              window.location.href = 'home.php';
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
    background-color: #f5f7fa;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    font-family: 'Segoe UI', sans-serif;
  }

  .container {
    max-width: 400px;
    width: 100%;
    background-color: white;
    padding: 40px 30px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    text-align: center;
  }

  h2 {
    font-weight: 700;
    font-size: 20px;
    text-transform: uppercase;
    margin-bottom: 30px;
    color: #333;
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
    background-color: #6c73ff;
    border: none;
    padding: 12px;
    font-weight: bold;
    width: 100%;
    border-radius: 8px;
    font-size: 15px;
  }

  .btn-primary:hover {
    background-color: #5b62e0;
  }

  a {
    display: block;
    margin-top: 20px;
    color: #6c73ff;
    font-weight: bold;
    font-size: 13px;
    text-decoration: none;
  }

  .alert {
    background-color: #ffe5e5;
    color: #b10000;
    padding: 10px;
    border-radius: 5px;
    font-size: 14px;
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
