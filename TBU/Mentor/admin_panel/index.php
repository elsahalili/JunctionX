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
      background-color: #f5f7fa;
      font-family: 'Segoe UI', sans-serif;
      color: #2c3e50;
    }

    .navbar-custom {
      background: linear-gradient(135deg, #823341, #c77482);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .navbar-brand {
      font-weight: 600;
      font-size: 1.5rem;
      color: #fff !important;
    }

    .navbar-nav .nav-link {
      color: #fff !important;
      margin-left: 15px;
      font-weight: 500;
      transition: opacity 0.3s;
    }

    .navbar-nav .nav-link:hover {
      opacity: 0.85;
    }

    .dashboard-header {
      text-align: center;
      margin-top: 80px;
      margin-bottom: 40px;
      animation: fadeUpIn 0.8s ease-out both;
    }

    .dashboard-header h2 {
      font-weight: 700;
      font-size: 2.3rem;
      color: #673c26;
    }

    .dashboard-container {
      animation: fadeUpIn 1s ease-out both;
    }

    .dashboard-card {
      background-color: #fff;
      border-radius: 18px;
      padding: 30px;
      text-align: center;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
      transition: all 0.3s ease;
      text-decoration: none;
      color: inherit;
      display: block;
    }

    .dashboard-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.1);
      background-color: #fff5f5;
    }

    .dashboard-card .bi {
      font-size: 2.6rem;
      margin-bottom: 12px;
      color: #823341;
    }

    .logout-btn {
      background-color: #ffeaea;
    }

    .logout-btn:hover {
      background-color: #ffd3d3;
    }

    @media (max-width: 576px) {
      .navbar-brand {
        font-size: 1.2rem;
      }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#"><i class="bi bi-speedometer2 me-2"></i>Admin Panel</a>
      <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="adminNavbar">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="admin/logout.php"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Header -->
  <div class="dashboard-header">
    <h2>Welcome to the Admin Dashboard</h2>
  </div>

  <!-- Dashboard Grid -->
  <div class="container dashboard-container pb-5">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
      <div class="col">
        <a href="admin/manage_universities.php" class="dashboard-card">
          <i class="bi bi-building"></i>
          <h5 class="mt-2">Manage Universities</h5>
        </a>
      </div>

      <div class="col">
        <a href="admin/manage_users.php" class="dashboard-card">
          <i class="bi bi-people"></i>
          <h5 class="mt-2">Manage Users</h5>
        </a>
      </div>

      <div class="col">
        <a href="admin/notifications.php" class="dashboard-card">
          <i class="bi bi-bell"></i>
          <h5 class="mt-2">Manage Notifications</h5>
        </a>
      </div>

      <div class="col">
        <a href="manage_events.php" class="dashboard-card">
          <i class="bi bi-calendar-event"></i>
          <h5 class="mt-2">Manage Events</h5>
        </a>
      </div>

      <div class="col">
        <a href="admin/quizzes.php" class="dashboard-card">
          <i class="bi bi-question-circle"></i>
          <h5 class="mt-2">Manage Quiz Questions</h5>
        </a>
      </div>

      <div class="col">
        <a href="admin/logout.php" class="dashboard-card logout-btn">
          <i class="bi bi-box-arrow-right"></i>
          <h5 class="mt-2">Log Out</h5>
        </a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
