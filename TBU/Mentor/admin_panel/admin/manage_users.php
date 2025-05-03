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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="mb-4 text-center">User Management</h2>
    <a href="../index.php" class="btn btn-secondary mb-3">Back to Dashboard</a>

    <table class="table table-bordered table-striped">
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
            <!-- Link the Edit button to the correct page with email -->
            <a href="edit_user.php?email=<?= urlencode($user["email"]) ?>" class="btn btn-sm btn-warning">Edit</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
