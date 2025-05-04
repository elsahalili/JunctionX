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
    $data[$userIndex]['name'] = $_POST['name'];
    // leave email readonly
    file_put_contents($usersFile, json_encode($data, JSON_PRETTY_PRINT));
    header("Location: manage_users.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit User</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Fade‑Up animation */
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
      max-width: 500px;
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
      padding: 10px 0;
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
    <h2 class="text-center mb-4">Edit User</h2>

    <div class="btn-back text-center">
      <a href="manage_users.php">← Back to Users</a>
    </div>

    <div class="card-edit">
      <form method="POST">
        <div class="mb-4">
          <label for="name" class="form-label">Name</label>
          <input 
            type="text" 
            id="name" 
            name="name" 
            class="form-control" 
            value="<?= htmlspecialchars($data[$userIndex]['name'] ?? '') ?>" 
            required>
        </div>

        <div class="mb-4">
          <label for="email" class="form-label">Email</label>
          <input 
            type="email" 
            id="email" 
            name="email" 
            class="form-control" 
            value="<?= htmlspecialchars($data[$userIndex]['email']) ?>" 
            readonly>
        </div>

        <button type="submit" class="btn-update">Update User</button>
      </form>
    </div>
  </div>
</body>
</html>
