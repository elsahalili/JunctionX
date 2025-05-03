<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("../data/admins.json"), true);
    $email = $_POST["email"];
    $password = $_POST["password"];
    foreach ($data as $admin) {
        if ($admin["email"] === $email && $admin["password"] === $password) {
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card p-4 shadow">
          <h2 class="mb-4 text-center">Admin Login</h2>
          <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
          <form method="post">
            <div class="mb-3">
              <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
              <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
