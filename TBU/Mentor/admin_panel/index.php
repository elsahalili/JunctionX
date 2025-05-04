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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    @keyframes fadeUpIn {
      0%   { opacity: 0; transform: translateY(30px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    body {
      background-color: #eef2f7;
      font-family: 'Segoe UI', sans-serif;
      color: #2c3e50;
    }

    .dashboard-container {
      animation: fadeUpIn 0.8s ease-out both;
    }

    .dashboard-header {
      background: linear-gradient(135deg, #823341, #c77482);
      padding: 40px 0;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      margin-bottom: 40px;
      color: #fff;
      text-align: center;
    }

    .dashboard-header h1 {
      font-size: 2.5rem;
      font-weight: 700;
      margin: 0;
      animation: fadeUpIn 1s ease-out both;
    }

    .dashboard-card {
      background-color: #fff;
      border-radius: 16px;
      padding: 30px;
      text-align: center;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
      transition: transform 0.3s, box-shadow 0.3s, background-color 0.2s;
      animation: fadeUpIn 1.2s ease-out both;
      color: inherit;
      text-decoration: none;
      display: block;
    }

    .dashboard-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 28px rgba(0, 0, 0, 0.12);
      background-color: #fdf6f6;
      text-decoration: none;
    }

    .dashboard-card .bi {
      font-size: 2.5rem;
      margin-bottom: 15px;
      color: #823341;
    }

    .logout-btn {
      background-color: #ffeaea;
    }

    .logout-btn:hover {
      background-color: #ffcccc;
    }
  </style>
</head>
<body>
  <div class="container dashboard-container py-5">
    <div class="dashboard-header">
      <h1>University Admin Dashboard</h1>
    </div>

    <div class="row row-cols-1 row-cols-sm-3 g-4">
      <div class="col">
        <a href="admin/manage_universities.php" class="dashboard-card text-decoration-none">
          <i class="bi bi-building"></i>
          <h5 class="mt-2">Manage Universities</h5>
        </a>
      </div>

      <div class="col">
        <a href="admin/manage_users.php" class="dashboard-card text-decoration-none">
          <i class="bi bi-people"></i>
          <h5 class="mt-2">Manage Users</h5>
        </a>
      </div>

      <div class="col">
        <a href="admin/notifications.php" class="dashboard-card text-decoration-none">
          <i class="bi bi-bell"></i>
          <h5 class="mt-2">Manage Notifications</h5>
        </a>
      </div>

      <div class="col">
        <a href="admin/events.php" class="dashboard-card text-decoration-none">
          <i class="bi bi-calendar-event"></i>
          <h5 class="mt-2">Manage Events</h5>
        </a>
      </div>

      <div class="col">
        <a href="admin/quizzes.php" class="dashboard-card text-decoration-none">
          <i class="bi bi-question-circle"></i>
          <h5 class="mt-2">Manage Quiz Questions</h5>
        </a>
      </div>

      <div class="col">
        <a href="admin/logout.php" class="dashboard-card text-decoration-none logout-btn">
          <i class="bi bi-box-arrow-right"></i>
          <h5 class="mt-2">Log Out</h5>
        </a>
      </div>
    </div>
  </div>
</body>
</html>
