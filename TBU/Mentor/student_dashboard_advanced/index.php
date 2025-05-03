<?php
$favorites = json_decode(file_get_contents("data/favorites.json"), true);
$notifications = json_decode(file_get_contents("data/notifications.json"), true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Smart Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container py-5">
  <div class="text-center mb-5">
    <h1 class="fw-bold">🚀 Interactive Student Dashboard</h1>
    <p class="text-muted">Track your favorite programs and never miss an update!</p>
  </div>
  <div class="row g-4">
    <div class="col-md-6">
      <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4">⭐ Favorite Programs</div>
        <div class="card-body">
          <ul id="fav-list" class="list-group mb-3">
            <?php foreach($favorites as $program): ?>
              <li class="list-group-item"><?= $program ?></li>
            <?php endforeach; ?>
          </ul>
          <div class="input-group">
            <input type="text" id="new-fav" class="form-control" placeholder="Add new favorite">
            <button class="btn btn-success" onclick="addFavorite()">Add</button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card shadow rounded-4">
        <div class="card-header bg-info text-white rounded-top-4">🔔 Notifications</div>
        <div class="card-body">
          <ul id="notif-list" class="list-group">
            <?php foreach($notifications as $note): ?>
              <li class="list-group-item"><?= $note ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Toast Area -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
  <div id="toast" class="toast align-items-center text-bg-success border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body" id="toast-body">Favorite added!</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/script.js"></script>
</body>
</html>
