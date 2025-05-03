<?php
$error = "";
$success = "";

$usersFile = 'users.json';
$usersDataDir = 'users_data';

if (!is_dir($usersDataDir)) {
  mkdir($usersDataDir);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = trim($_POST["name"] ?? "");
  $surname = trim($_POST["surname"] ?? "");
  $email = trim($_POST["email"] ?? "");
  $password = trim($_POST["password"] ?? "");

  if ($name && $surname && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password)) {
    $users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

    foreach ($users as $user) {
      if ($user['email'] === $email) {
        $error = "Email already taken.";
        break;
      }
    }

    if (!$error) {
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $filename = $usersDataDir . '/' . strtolower($name) . '_' . time() . '.json';

      $users[] = [
        'name' => $name,
        'surname' => $surname,
        'email' => $email,
        'password' => $hashedPassword,
        'file' => $filename
      ];

      $personalData = [
        'name' => $name,
        'surname' => $surname,
        'email' => $email,
        'cv_uploaded' => false,
        'quiz_results' => [],
        'matched_faculties' => []
      ];

      file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
      file_put_contents($filename, json_encode($personalData, JSON_PRETTY_PRINT));

      echo "<script>
        alert('Welcome, $name! You have signed up successfully.');
        window.location.href = 'home.php';
      </script>";
      exit();
    }
  } else {
    $error = "Please fill in all fields correctly.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  body {
    background-color: #f9f9f9;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    font-family: 'Segoe UI', sans-serif;
  }

  .container {
    max-width: 400px;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
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
  <div class="container">
    <h2 class="text-center mb-4">Sign Up</h2>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
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
