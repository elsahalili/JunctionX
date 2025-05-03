<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

// Load users data
$usersFile = "../../users.json";
$data = json_decode(file_get_contents($usersFile), true) ?? [];

// Check if email is provided in URL
if (!isset($_GET['email'])) {
    echo "User not found!";
    exit();
}

$email = $_GET['email'];
$userFound = false;
$userIndex = -1;

// Search for the user by email
foreach ($data as $index => $user) {
    if ($user['email'] === $email) {
        $userFound = true;
        $userIndex = $index;
        break;
    }
}

// If user is not found, show an error message
if (!$userFound) {
    echo "User not found!";
    exit();
}

// If form is submitted, update the user data
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the new data from the form
    $data[$userIndex]['name'] = $_POST['name'];
    $data[$userIndex]['email'] = $_POST['email']; // You can choose to leave this editable or not
    
    // Save the updated data back to the JSON file
    file_put_contents($usersFile, json_encode($data, JSON_PRETTY_PRINT));

    // Redirect back to the user management page after update
    header("Location: manage_users.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="mb-4 text-center">Edit User</h2>
    <a href="manage_users.php" class="btn btn-secondary mb-3">Back to Users</a>

    <!-- Display edit form with existing user data -->
    <form method="POST">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($data[$userIndex]['name'] ?? '') ?>" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($data[$userIndex]['email']) ?>" readonly>
      </div>

      <button type="submit" class="btn btn-success">Update User</button>
    </form>
  </div>
</body>
</html>

