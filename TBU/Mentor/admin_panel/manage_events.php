<?php
session_start();
if (!isset($_SESSION["admin"])) {
    echo "Unauthorized access.";
    exit();
}

$eventsFile = __DIR__ . '/../data/events.json';
$events = file_exists($eventsFile) ? json_decode(file_get_contents($eventsFile), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_event'])) {
    $new_event = [
        "title" => $_POST["title"] ?? "",
        "description" => $_POST["description"] ?? "",
        "date" => $_POST["date"] ?? "",
        "time" => $_POST["time"] ?? "",
        "location" => $_POST["location"] ?? ""
    ];
    $events[] = $new_event;
    file_put_contents($eventsFile, json_encode($events, JSON_PRETTY_PRINT));
    header("Location: manage_events.php");
    exit();
}

if (isset($_GET['delete'])) {
    $event_index = $_GET['delete'];
    unset($events[$event_index]);
    $events = array_values($events);
    file_put_contents($eventsFile, json_encode($events, JSON_PRETTY_PRINT));
    header("Location: manage_events.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <title>Manage Events</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f8;
            padding: 40px;
            color: #333;
            animation: fadeIn 0.8s ease-out both;
        }

        h1, h2 {
            color: #2c3e50;
            text-align: center;
        }

        form {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            animation: fadeUp 0.6s ease-out;
        }

        input, textarea, button {
            padding: 12px;
            margin-top: 10px;
            width: 100%;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: border-color 0.3s ease;
        }

        input:focus, textarea:focus {
            border-color: #673c26;
            outline: none;
        }

        button {
            background: linear-gradient(to right, #823341, #a14a58);
            color: white;
            font-weight: bold;
            border: none;
            margin-top: 15px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: linear-gradient(to right, #a14a58, #823341);
        }

        .event-box {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin: 20px auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
            max-width: 700px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeUp 0.5s ease-out;
        }

        .event-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .event-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #673c26;
            margin-bottom: 5px;
        }

        .event-date {
            font-size: 0.95rem;
            color: #888;
            margin-bottom: 10px;
        }

        .event-description {
            font-size: 1rem;
            color: #555;
            margin-bottom: 10px;
        }

        .delete-link {
            display: inline-block;
            color: #d9534f;
            text-decoration: none;
            font-weight: bold;
            margin-top: 10px;
        }

        .delete-link:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (min-width: 992px) {
      .navbar-nav-center {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
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
          <a class="nav-link text-dark" href="admin/manage_universities.php">Universities</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="admin/manage_users.php">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="admin/notifications.php">Notifications</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="manage_events.php">Events</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="admin/quizzes.php">Questions</a>
        </li>
      </ul>
    </div>

    <!-- Right-aligned Button -->
    <div class="d-none d-lg-block">
      <a class="btn btn-primary rounded-pill px-4" href="index.php">Back</a>
    </div>
  </div>
</nav>


    <h1 class="mt-lg-5">Event Management Dashboard</h1>

    <h2>Add a New Event</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Event Title" required>
        <textarea name="description" placeholder="Event Description" required></textarea>
        <input type="date" name="date" required>
        <input type="time" name="time" required>
        <input type="text" name="location" placeholder="Event Location" required>
        <button type="submit" name="add_event">Add Event</button>
    </form>

    <h2>Upcoming Events</h2>
    <?php if (empty($events)) : ?>
        <p style="text-align:center;">No events available.</p>
    <?php else : ?>
        <?php foreach ($events as $index => $event) : ?>
            <div class="event-box">
                <div class="event-title"><?= htmlspecialchars($event["title"]) ?></div>
                <div class="event-date">
                <?= htmlspecialchars($event["date"]) ?> at <?= isset($event["time"]) ? htmlspecialchars($event["time"]) : 'N/A' ?> | <?= htmlspecialchars($event["location"]) ?>
            </div>

                <div class="event-description"><?= htmlspecialchars($event["description"]) ?></div>
                <a class="delete-link" href="?delete=<?= $index ?>" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>
