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
    $data[$uniIndex]['description'] = $_POST['description'];
    $data[$uniIndex]['location']    = $_POST['location'];
    $data[$uniIndex]['website']     = $_POST['website'];
    $data[$uniIndex]['image']       = $_POST['image'];
    $data[$uniIndex]['chatBot']     = $_POST['chatBot'];

    file_put_contents($universitiesFile, json_encode($data, JSON_PRETTY_PRINT));
    header("Location: manage_universities.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit University</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Fade‑Up & Fade‑In Animations */
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
      max-width: 600px;
    }

    .card-edit {
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

    .btn-back {
      display: inline-block;
      margin-bottom: 20px;
      animation: fadeUpIn 0.6s ease-out both;
    }

    .btn-back a {
      background-color: #823341;
      color: #fff;
      padding: 8px 20px;
      border-radius: 8px;
      text-decoration: none;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-back a:hover {
      background-color: #5e2431;
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    }

    .form-control {
      border-radius: 8px;
      box-shadow: inset 0 2px 6px rgba(0,0,0,0.03);
      transition: border-color 0.3s ease;
    }

    .form-control:focus {
      border-color: #823341;
      box-shadow: 0 0 0 2px rgba(130,51,65,0.2);
    }

    .btn-update {
      background-color: #c77482;
      color: #fff;
      padding: 12px;
      width: 100%;
      border: none;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transition: background-color 0.2s ease, transform 0.2s ease;
    }

    .btn-update:hover {
      background-color: #a4535e;
      transform: translateY(-1px);
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <h2 class="text-center mb-4">Edit University</h2>

    <div class="btn-back text-center">
      <a href="manage_universities.php">← Back to Universities</a>
    </div>

    <div class="card-edit">
      <form method="POST">
        <div class="mb-4">
          <label for="description" class="form-label">Description</label>
          <input
            type="text"
            id="description"
            name="description"
            class="form-control"
            value="<?= htmlspecialchars($data[$uniIndex]['description']) ?>"
            required>
        </div>

        <div class="mb-4">
          <label for="location" class="form-label">Location</label>
          <input
            type="text"
            id="location"
            name="location"
            class="form-control"
            value="<?= htmlspecialchars($data[$uniIndex]['location']) ?>"
            required>
        </div>

        <div class="mb-4">
          <label for="website" class="form-label">Website</label>
          <input
            type="url"
            id="website"
            name="website"
            class="form-control"
            value="<?= htmlspecialchars($data[$uniIndex]['website']) ?>"
            required>
        </div>

        <div class="mb-4">
          <label for="image" class="form-label">Image Filename</label>
          <input
            type="text"
            id="image"
            name="image"
            class="form-control"
            value="<?= htmlspecialchars($data[$uniIndex]['image']) ?>"
            required>
          <div class="form-text">Ensure the image is in <code>/admin_panel/images/</code></div>
        </div>

        <div class="mb-4">
          <label for="chatBot" class="form-label">ChatBot URL</label>
          <input
            type="text"
            id="chatBot"
            name="chatBot"
            class="form-control"
            value="<?= htmlspecialchars($data[$uniIndex]['chatBot']) ?>"
            required>
        </div>

        <button type="submit" class="btn-update">Update University</button>
      </form>
    </div>
  </div>
</body>
</html>
