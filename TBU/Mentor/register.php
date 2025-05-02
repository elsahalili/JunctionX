<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = htmlspecialchars(trim($_POST["name"] ?? ""));
  $surname = htmlspecialchars(trim($_POST["surname"] ?? ""));
  $email = htmlspecialchars(trim($_POST["email"] ?? ""));

  // Simple validation
  if ($name && $surname && filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Success - you can save to database or send an email here
    $success = "Thank you, $name! Your sign-up was successful.";
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
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="mb-4">Sign Up</h2>

    <?php if (!empty($success)): ?>
      <div class="alert alert-success"><?php echo $success; ?></div>
    <?php elseif (!empty($error)): ?>
      <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="surname" class="form-label">Surname</label>
        <input type="text" name="surname" id="surname" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" name="email" id="email" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>
  </div>
</body>
</html>
