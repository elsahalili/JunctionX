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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', sans-serif;
      color: #333;
      overflow-x: hidden;
    }

    h2, h4, h5 {
      text-align: center;
      color: #333;
    }

    .badge-location, .badge-chatbot {
      color: #823341;
      background-color: #fcecef;
      padding: 6px 12px;
      border-radius: 12px;
      font-size: 0.85rem;
      display: inline-block;
    }

    .badge-chatbot {
      background-color: #f9e5e8;
    }

    .btn-warning {
      background-color: #c77482;
      border-color: #c77482;
      color: white;
      border-radius: 8px;
      font-size: 0.85rem;
      padding: 5px 12px;
    }

    .btn-warning:hover {
      color: white;
      background-color: #a4535e;
    }

    .btn-secondary {
      background-color: #ac5662;
      border-color: #ac5662;
    }

    .btn-secondary:hover {
      background-color: #823341;
      border-color: #823341;
    }

    .university-img {
      border-radius: 8px;
      width: 50px;
      height: 50px;
      object-fit: cover;
    }

    .website-link {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background-color: #fcecef;
      color: #823341;
      font-weight: 500;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      text-decoration: none;
    }

    .website-link:hover {
      background-color: #e7cad0;
      color: #5a232e;
    }

    .custom-form {
      background-color: #ffffff;
      border: 1px solid #e0e0e0;
      padding: 30px 25px;
      border-radius: 12px;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
    }

    .custom-form .form-group {
      position: relative;
      margin-bottom: 1.5rem;
    }

    .custom-form input {
      width: 100%;
      padding: 12px;
      font-size: 1rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      background-color: #fff;
    }

    .custom-form label {
      position: absolute;
      top: 50%;
      left: 12px;
      transform: translateY(-50%);
      background-color: white;
      padding: 0 4px;
      color: #999;
      font-size: 0.95rem;
      pointer-events: none;
      transition: 0.2s ease all;
    }

    .custom-form input:focus + label,
    .custom-form input:not(:placeholder-shown) + label {
      top: 0;
      font-size: 0.75rem;
      color: #823341;
      transform: translateY(-50%) scale(0.95);
    }

    .btn-submit {
      width: 100%;
      padding: 10px;
      background-color: #823341;
      color: #fff;
      border: none;
      font-weight: 600;
      border-radius: 6px;
      transition: all 0.3s ease;
    }

    .btn-submit:hover {
      opacity: 0.9;
      transform: scale(1.02);
    }

    @media (max-width: 992px) {
      .row.flex-lg-row {
        flex-direction: column;
      }

      .table-responsive {
        margin-bottom: 30px;
      }
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
  <div class="container position-relative">
    <!-- Logo -->
    <a class="navbar-brand fw-bold text-primary" href="index.php">MyAdmin</a>

    <!-- Toggler for mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Centered Links -->
    <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
      <ul class="navbar-nav navbar-nav-center">
        <li class="nav-item">
          <a class="nav-link text-dark" href="manage_universities.php">Universities</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="manage_users.php">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="notifications.php">Notifications</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="manage_events.php">Events</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="quizzes.php">Questions</a>
        </li>
      </ul>
    </div>

    <!-- Right-aligned Button -->
    <div class="d-none d-lg-block">
      <a class="btn btn-primary rounded-pill px-4" href="index.php">Back</a>
    </div>
  </div>
</nav>

  <div class="container py-4 mt-lg-5">
    <h2 class="mb-4">Manage Universities</h2>

    <div class="row flex-lg-row d-flex justify-content-between">
      <!-- Left: Table -->
      <div class="col-lg-7 mb-4">
        <div class="table-responsive bg-white p-3 rounded shadow-sm">
          <h4 class="mb-3 text-secondary fw-bold">University Listings</h4>
          <table class="table align-middle table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Description</th>
                <th>Location</th>
                <th>Website</th>
                <th>ChatBot</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; foreach($data as $uni): ?>
                <tr>
                  <td><?= $i++ ?></td>
                  <td class="fw-medium text-dark"><?= htmlspecialchars($uni['description']) ?></td>
                  <td><span class="badge-location"><?= htmlspecialchars($uni['location']) ?></span></td>
                  <td>
                    <a href="<?= $uni['website'] ?>" target="_blank" class="website-link">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16">
                        <path d="M14 3h7v7h-2V6.41l-9.29 9.3-1.42-1.42L17.59 5H14V3z"/>
                        <path d="M5 5h4V3H5a2 2 0 0 0-2 2v4h2V5zm0 14v-4H3v4a2 2 0 0 0 2 2h4v-2H5zm14 0h-4v2h4a2 2 0 0 0 2-2v-4h-2v4z"/>
                      </svg>
                      Visit Site
                    </a>
                  </td>
                  <td><span class="badge-chatbot"><?= htmlspecialchars($uni['chatBot']) ?></span></td>
                  <td>
                    <a href="edit_university.php?description=<?= urlencode($uni['description']) ?>" class="btn btn-warning">Edit</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Right: Form -->
      <div class="col-lg-5">
        <form class="custom-form" action="../api/add.php" method="POST">
          <h5 class="text-center mb-4">Add New University</h5>
          <input type="hidden" name="type" value="universities">

          <div class="form-group">
            <input type="text" name="description" id="description" placeholder=" " required>
            <label for="description">University Description</label>
          </div>

          <div class="form-group">
            <input type="text" name="location" id="location" placeholder=" " required>
            <label for="location">Location</label>
          </div>

          <div class="form-group">
            <input type="text" name="website" id="website" placeholder=" " required>
            <label for="website">Website</label>
          </div>


          <div class="form-group">
            <input type="text" name="chatBot" id="chatBot" placeholder=" ">
            <label for="chatBot">ChatBot URL</label>
          </div>

          <button type="submit" class="btn-submit">Submit</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
