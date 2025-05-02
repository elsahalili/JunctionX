<?php 
include_once('config.php');

// Ensure the user is logged in and get the logged-in username from the session
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Fetch only the logged-in user's data
    $sql = "SELECT * FROM users WHERE username = :username";
    $prep = $conn->prepare($sql);
    
    // Bind the parameter
    $prep->bindParam(':username', $username, PDO::PARAM_STR);
    
    // Execute the query
    $prep->execute();
    
    // Fetch the user's data
    $user_data = $prep->fetch(PDO::FETCH_ASSOC);
} else {
    // Handle the case where the user is not logged in
    echo "You are not logged in.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile</title>
  <style>
    /* Global Styles */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f0f0f0;
        color: #333;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
    /* Card Container */
    .profile-container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 80%;
        max-width: 600px;
        padding: 30px;
        text-align: center;
    }
    /* Header */
    h2 {
        color: #2c3e50;
        font-size: 32px;
        margin-bottom: 20px;
    }
    h3 {
        color: #3498db;
        font-size: 24px;
        margin-bottom: 30px;
    }
    /* Table Styling */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    table th, table td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ddd;
        font-size: 18px;
    }
    table th {
        background-color: #3498db;
        color: white;
    }
    table td {
        background-color: #ecf0f1;
    }
    /* Buttons and Links */
    .edit-link {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #e67e22;
        color: white;
        text-decoration: none;
        font-weight: bold;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    .edit-link:hover {
        background-color: #d35400;
    }
    .logout-link {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #e74c3c;
        color: white;
        text-decoration: none;
        font-weight: bold;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    .logout-link:hover {
        background-color: #c0392b;
    }
  </style>
</head>
<body>

<div class="profile-container">
  <?php
  if (isset($_SESSION['username'])) {
      echo '<h2>Hello, ' . htmlspecialchars($_SESSION['username']) . '!</h2>';
  } else {
      echo '<h2>You are not logged in.</h2>';
  }
  ?>

  <h3>My Profile</h3>
  
  <table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Password (hashed)</th>
    </tr>
    <?php if ($user_data): ?>
        <tr>
            <td><?= htmlspecialchars($user_data['id']) ?></td>
            <td><?= htmlspecialchars($user_data['username']) ?></td>
            <td><?= htmlspecialchars(substr($user_data['password'], 0, 10)) . '...' ?></td>
        </tr>
    <?php else: ?>
        <tr><td colspan="3">No user found.</td></tr>
    <?php endif; ?>
  </table>

  <a href="edit_profile.php" class="edit-link">Edit Profile</a>
</div>

</body>
</html>
