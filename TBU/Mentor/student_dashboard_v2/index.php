<?php
$favorites = json_decode(file_get_contents("data/favorites.json"), true);
$notifications = json_decode(file_get_contents("data/notifications.json"), true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container mt-5">
  <h1 class="mb-4">Welcome to Your Dashboard</h1>
  <div class="row">
    <div class="col-md-6">
      <div class="card mb-4">
        <div class="card-header">Favorite Programs</div>
        <div class="card-body">
          <ul id="fav-list">
            <?php foreach($favorites as $program): ?>
              <li><?= $program ?></li>
            <?php endforeach; ?>
          </ul>
          <input type="text" id="new-fav" class="form-control mb-2" placeholder="Add new favorite program">
          <button class="btn btn-primary" onclick="addFavorite()">Add</button>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card mb-4">
        <div class="card-header">Notifications</div>
        <div class="card-body">
          <ul id="notif-list">
            <?php foreach($notifications as $note): ?>
              <li><?= $note ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="assets/script.js"></script>
</body>
</html>
