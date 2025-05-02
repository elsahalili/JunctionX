<?php
// Database configuration
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "junctionx";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$error = "";
$success = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = trim($_POST["email"] ?? "");
  $password = trim($_POST["password"] ?? "");

  if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password)) {
    $stmt = $conn->prepare("SELECT name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $stmt->bind_result($name, $hashedPassword);
      $stmt->fetch();

      if (password_verify($password, $hashedPassword)) {
        // Successful login
        echo "<script>
          alert('Welcome back, $name!');
          window.location.href = 'index.html';
        </script>";
        exit();
      } else {
        $error = "Incorrect password.";
      }
    } else {
      $error = "No account found with that email.";
    }

    $stmt->close();
  } else {
    $error = "Please enter a valid email and password.";
  }
}

$conn->close();
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
    font-family: 'Segoe UI', sans-serif;
  }

  .container {
    max-width: 400px;
    width: 100%;
    background-color: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    text-align: center;
  }

  h2 {
    font-size: 20px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 30px;
    color: #333;
  }

  .form-label {
    display: none;
  }

  .form-control {
    background-color: #f1f1f1;
    border: none;
    border-radius: 5px;
    padding: 14px 12px;
    font-size: 14px;
    margin-bottom: 15px;
  }

  .btn-primary {
    background-color: #6c73ff;
    border: none;
    padding: 12px;
    font-weight: bold;
    width: 100%;
    border-radius: 5px;
    font-size: 15px;
  }

  .btn-primary:hover {
    background-color: #5057d5;
  }

  a {
    display: block;
    margin-top: 15px;
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
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="mb-4">Login</h2>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
      </div>

      <button type="submit" class="btn btn-primary">Log In</button> <br>
      <a href="register.php">Sign Up</a>
    </form>
  </div>
</body>
</html>
