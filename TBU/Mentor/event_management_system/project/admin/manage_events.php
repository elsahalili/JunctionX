<?php
session_start();

// Only allow admins to access
if (!isset($_SESSION["admin"])) {
    echo "Unauthorized access.";
    exit();
}

$eventsFile = __DIR__ . '/../data/events.json';

// Read and decode existing events
$events = json_decode(file_get_contents($eventsFile), true);

// Handle Add Event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_event'])) {
    $new_event = [
        "title" => $_POST["title"] ?? "",
        "description" => $_POST["description"] ?? "",
        "date" => $_POST["date"] ?? "",
        "location" => $_POST["location"] ?? ""
    ];

    // Add event to the array
    $events[] = $new_event;

    // Save to the file
    file_put_contents($eventsFile, json_encode($events, JSON_PRETTY_PRINT));

    header("Location: manage_events.php");
    exit();
}

// Handle Delete Event
if (isset($_GET['delete'])) {
    $event_index = $_GET['delete'];
    unset($events[$event_index]);

    // Re-index the array after deleting
    $events = array_values($events);

    // Save back to the file
    file_put_contents($eventsFile, json_encode($events, JSON_PRETTY_PRINT));

    header("Location: manage_events.php");
    exit();
}

// Handle Edit Event (You can improve this part based on your needs)
if (isset($_GET['edit'])) {
    $event_index = $_GET['edit'];
    $event = $events[$event_index] ?? null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UniMatch</title>
    <style>
        body { font-family: sans-serif; margin: 2rem; }
        .event-box {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            background-color: #f9f9f9;
        }
        .event-title { font-size: 1.2rem; font-weight: bold; }
        .event-date { font-size: 0.9rem; color: #666; }
        input, textarea { padding: 0.5rem; margin: 0.5rem 0; width: 100%; }
    </style>
</head>
<body>
    <h1>Manage Events</h1>

    <h2>Add Event</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Event Title" required>
        <textarea name="description" placeholder="Event Description" required></textarea>
        <input type="date" name="date" required>
        <input type="text" name="location" placeholder="Event Location" required>
        <button type="submit" name="add_event">Add Event</button>
    </form>

    <h2>Existing Events</h2>
    <?php if (empty($events)) : ?>
        <p>No events available.</p>
    <?php else : ?>
        <?php foreach ($events as $index => $event) : ?>
            <div class="event-box">
                <div class="event-title"><?= htmlspecialchars($event["title"]) ?></div>
                <div class="event-date"><?= htmlspecialchars($event["date"]) ?> | <?= htmlspecialchars($event["location"]) ?></div>
                <p><?= htmlspecialchars($event["description"]) ?></p>
                <a href="?delete=<?= $index ?>">Delete</a> |
                <a href="?edit=<?= $index ?>">Edit</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>