<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

// Load universities data
$universitiesFile = "../../universities.json";
$data = json_decode(file_get_contents($universitiesFile), true) ?? [];

// Check if description is provided in the URL
if (!isset($_GET['description'])) {
    echo "University not found!";
    exit();
}

$description = $_GET['description'];
$uniFound = false;
$uniIndex = -1;

// Search for the university by description
foreach ($data as $index => $university) {
    if ($university['description'] === $description) {
        $uniFound = true;
        $uniIndex = $index;
        break;
    }
}

// If university is not found, show an error message
if (!$uniFound) {
    echo "University not found!";
    exit();
}

// If form is submitted, update the university data
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get new data from the form
    $data[$uniIndex]['description'] = $_POST['description'];
    $data[$uniIndex]['location'] = $_POST['location'];
    $data[$uniIndex]['website'] = $_POST['website'];
    $data[$uniIndex]['image'] = $_POST['image'];
    $data[$uniIndex]['chatBot'] = $_POST['chatBot'];

    // Save updated data back to the JSON file
    file_put_contents($universitiesFile, json_encode($data, JSON_PRETTY_PRINT));

    // Redirect back to the manage universities page after update
    header("Location: manage_universities.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit University</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="mb-4 text-center">Edit University</h2>
    <a href="manage_universities.php" class="btn btn-secondary mb-3">Back to Universities</a>

    <!-- Display the edit form with current university data -->
    <form method="POST">
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <input type="text" class="form-control" name="description" value="<?= htmlspecialchars($data[$uniIndex]['description']) ?>" required>
      </div>

      <div class="mb-3">
        <label for="location" class="form-label">Location</label>
        <input type="text" class="form-control" name="location" value="<?= htmlspecialchars($data[$uniIndex]['location']) ?>" required>
      </div>

      <div class="mb-3">
        <label for="website" class="form-label">Website</label>
        <input type="url" class="form-control" name="website" value="<?= htmlspecialchars($data[$uniIndex]['website']) ?>" required>
      </div>

      <div class="mb-3">
        <label for="image" class="form-label">Image Filename</label>
        <input type="text" class="form-control" name="image" value="<?= htmlspecialchars($data[$uniIndex]['image']) ?>" required>
        <div class="form-text">Make sure the image is in <code>/admin_panel/images/</code></div>
      </div>

      <div class="mb-3">
        <label for="chatBot" class="form-label">ChatBot File</label>
        <input type="text" class="form-control" name="chatBot" value="<?= htmlspecialchars($data[$uniIndex]['chatBot']) ?>" required>
      </div>

      <button type="submit" class="btn btn-success">Update University</button>
    </form>
  </div>
</body>
</html>
