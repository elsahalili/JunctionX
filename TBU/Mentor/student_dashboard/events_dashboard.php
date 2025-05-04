<?php
session_start();
if (!isset($_SESSION["student"])) {
    echo "Unauthorized access.";
    exit();
}
$eventsFile = __DIR__ . '/../data/events.json';
if (!file_exists($eventsFile)) {
    file_put_contents($eventsFile, json_encode([]));
}
$events = json_decode(file_get_contents($eventsFile), true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UniMatch</title>
    <style>
        body { font-family: sans-serif; margin: 2rem; }
        .event-box { border: 1px solid #ccc; border-radius: 10px; padding: 1rem; margin-bottom: 1rem; background-color: #f9f9f9; }
        .event-title { font-size: 1.2rem; font-weight: bold; }
        .event-date { font-size: 0.9rem; color: #666; }
    </style>
</head>
<body>
    <h1>📅 Upcoming Events</h1>
    <?php if (empty($events)) : ?>
        <p>No events available yet.</p>
    <?php else : ?>
        <?php foreach ($events as $event) : ?>
            <div class="event-box">
                <div class="event-title"><?= htmlspecialchars($event["title"]) ?></div>
                <div class="event-date"><?= htmlspecialchars($event["date"]) ?> | <?= htmlspecialchars($event["location"]) ?></div>
                <p><?= htmlspecialchars($event["description"]) ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
