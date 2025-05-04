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
        /* Reset and base styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f0f2f5, #e0eafc);
            padding: 2rem;
            color: #333;
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 1rem;
            color: #833442;
        }

        /* Fade-in-up animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Form styling */
        form {
            background-color: #ffffff;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: 0 auto 2rem auto;
            max-width: 600px;
            animation: fadeInUp 0.6s ease-out;
        }

        input, textarea {
            padding: 0.75rem;
            margin: 0.5rem 0;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input:focus, textarea:focus {
            border-color: #833442;
            outline: none;
        }

        button {
            background-color: #833442;
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #6a2a36;
        }

        .event-box {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.6s ease-out;
        }

        .event-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #833442;
        }

        .event-date {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.5rem;
        }

        a {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }


        :root {
      --main-color: #833442;
      --text-color: #333;
      --hover-color: #a14d5c;
    }

    .navbar {
      background-color: #fff;
    }

    .navbar-brand {
      color: var(--main-color) !important;
    }

    .navbar-nav .nav-link {
      color: var(--text-color);
      font-weight: 500;
      transition: color 0.3s;
    }

    .navbar-nav .nav-link:hover {
      color: var(--main-color);
    }

    .btn-custom {
      background-color: var(--main-color);
      color: #fff;
      border: none;
      transition: background-color 0.3s;
    }

    .btn-custom:hover {
      background-color: var(--hover-color);
      color: #fff;
    }

    @media (min-width: 992px) {
      .navbar-nav-center {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
      }
    }
    .btn-custom {
  background-color: #833442;
  color: #fff;
  border: none;
  padding: 0.5rem 1.2rem;
  border-radius: 30px;
  font-weight: 600;
  box-shadow: 0 4px 10px rgba(131, 52, 66, 0.3);
  transition: all 0.3s ease;
}

.btn-custom:hover {
  background-color: #a14d5c;
  box-shadow: 0 6px 14px rgba(131, 52, 66, 0.4);
  transform: translateY(-2px);
}

    </style>
</head>
<body>
    
<nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
  <div class="container position-relative">
    <!-- Logo -->
    <a class="navbar-brand fw-bold text-primary" href="#">MyAdmin</a>

    <!-- Toggler for mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Centered Links -->
    <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
      <ul class="navbar-nav navbar-nav-center">
        <li class="nav-item">
          <a class="nav-link text-dark" href="admin/manage_universities.php">University</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="admin/manage_users.php">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="admin/quizzes.php">Quiz</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="manage_events.php">Events</a>
        </li>
      </ul>
    </div>

    <!-- Right-aligned Button -->
    <div class="d-none d-lg-block">
      <a class="btn btn-custom" href="index.php">Back</a>
    </div>
  </div>
</nav>

    <h1 class="mt-5">Manage Events</h1>
    <h2>Add Event</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Event Title" required>
        <textarea name="description" placeholder="Event Description" required></textarea>
        <input type="date" name="date" required>
        <input type="text" name="location" placeholder="Event Location" required>
        <button type="submit" name="add_event" class="btn-custom">Add Event</button>
    </form>
    <h2>Existing Events</h2>
    <?php if (empty($events)) : ?>
        <p style="text-align: center;">No events available.</p>
    <?php else : ?>
        <?php foreach ($events as $index => $event) : ?>
            <div class="event-box">
                <div class="event-title"><?= htmlspecialchars($event["title"]) ?></div>
                <div class="event-date"><?= htmlspecialchars($event["date"]) ?> | <?= htmlspecialchars($event["location"]) ?></div>
                <p><?= htmlspecialchars($event["description"]) ?></p>
                <a href="?delete=<?= $index ?>">Delete</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>
