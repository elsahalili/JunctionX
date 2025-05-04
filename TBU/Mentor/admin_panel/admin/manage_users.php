<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

$data = json_decode(file_get_contents("../../users.json"), true) ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Users</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Fade In & Up Animation */
    @keyframes fadeUpIn {
      0%   { opacity: 0; transform: translateY(20px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', sans-serif;
      color: #333;
    }

    .container {
      max-width: 900px;
    }

    .card-custom {
      background-color: #fff;
      border-radius: 16px;
      padding: 30px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
      animation: fadeUpIn 0.8s ease-out both;
    }

    h2 {
      color: #4a3f55;
      font-weight: bold;
    }

    .btn-back-wrapper {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
      animation: fadeUpIn 0.6s ease-out both;
    }

    .btn-secondary {
      background-color: #823341;
      border: none;
      color: white;
      padding: 8px 24px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-secondary:hover {
      background-color: #5e2431;
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    }

    .table-responsive {
      animation: fadeUpIn 1s ease-out both;
    }

    .table {
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
    }

    .table thead th {
      background-color: #823341;
      color: #fff;
      border: none;
    }

    .table tbody tr {
      background-color: #fff;
      transition: background-color 0.3s ease;
    }

    .table tbody tr:hover {
      color: white;
      background-color: #f8ecef;
    }

    .btn-edit {
      background-color: #c77482;
      border: none;
      color: white;
      padding: 6px 14px;
      border-radius: 8px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
      transition: background-color 0.2s ease, transform 0.2s ease;
    }

    .btn-edit:hover {
      color: white;
      background-color: #a4535e;
      transform: translateY(-1px);
    }

    .table td, .table th {
      vertical-align: middle;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="card card-custom">
      <h2 class="mb-4 text-center">User Management</h2>

      <div class="btn-back-wrapper">
        <a href="../index.php" class="btn btn-secondary">Back to Dashboard</a>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead>
            <tr>
              <th>#</th>
              <th>Email</th>
              <th>Name</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data as $i => $user): ?>
            <tr>
              <td><?= $i + 1 ?></td>
              <td><?= htmlspecialchars($user["email"]) ?></td>
              <td><?= htmlspecialchars($user["name"] ?? 'N/A') ?></td>
              <td>
                <a href="edit_user.php?email=<?= urlencode($user["email"]) ?>" class="btn btn-sm btn-edit">Edit</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
