<?php
session_start();
if (!isset($_SESSION["admin"])) { 
    header("Location: login.php"); 
    exit(); 
}

$data = json_decode(file_get_contents("../../universities.json"), true) ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Universities</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="mb-4 text-center">Manage Universities</h2>
    <a href="../index.php" class="btn btn-secondary mb-3">Back to Dashboard</a>

    <table class="table table-bordered table-striped mb-4">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Description</th>
          <th>Location</th>
          <th>Website</th>
          <th>Image</th>
          <th>ChatBot</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; foreach($data as $uni): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($uni['description']) ?></td>
            <td><?= htmlspecialchars($uni['location']) ?></td>
            <td><a href="<?= $uni['website'] ?>" target="_blank"><?= $uni['website'] ?></a></td>
            <td><img src="../images/<?= $uni['image'] ?>" alt="" style="width: 50px;"></td>
            <td><?= htmlspecialchars($uni['chatBot']) ?></td>
            <td>
              <!-- Edit button now links to edit_university.php with the university description -->
              <a href="edit_university.php?description=<?= urlencode($uni['description']) ?>" class="btn btn-sm btn-warning">Edit</a>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="card">
      <div class="card-header bg-success text-white">
        <h5 class="mb-0">Add New University</h5>
      </div>
      <div class="card-body">
      <form action="../api/add.php" method="POST">
        <input type="hidden" name="type" value="universities">  <!-- Hidden type field -->
        
        <label for="description">University Description:</label><br>
        <input type="text" name="description" id="description" required><br><br>

        <label for="location">Location:</label><br>
        <input type="text" name="location" id="location" required><br><br>

        <label for="website">Website:</label><br>
        <input type="text" name="website" id="website" required><br><br>

        <label for="image">Image URL:</label><br>
        <input type="text" name="image" id="image"><br><br>

        <label for="chatBot">ChatBot URL:</label><br>
        <input type="text" name="chatBot" id="chatBot"><br><br>

        <button type="submit">Submit</button>
    </form>
      </div>
    </div>

  </div>
</body>
</html>
