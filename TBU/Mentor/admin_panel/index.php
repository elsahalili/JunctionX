<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: admin/login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h1 class="mb-4 text-center">🎓 University Admin Dashboard</h1>
    <div class="row g-4">
      <div class="col-md-4"><a href="admin/manage_universities.php" class="btn btn-primary w-100">Manage Universities</a></div>
      <div class="col-md-4"><a href="admin/manage_users.php" class="btn btn-primary w-100">Manage Users</a></div>
      <div class="col-md-4"><a href="admin/notifications.php" class="btn btn-primary w-100">Manage Notifications</a></div>
      <div class="col-md-4"><a href="admin/events.php" class="btn btn-primary w-100">Manage Events</a></div>
      <div class="col-md-4"><a href="admin/quizzes.php" class="btn btn-primary w-100">Manage Quiz Questions</a></div>
      <div class="col-md-4"><a href="admin/logout.php" class="btn btn-danger w-100">Logout</a></div>
    </div>
  </div>
</body>
</html>
