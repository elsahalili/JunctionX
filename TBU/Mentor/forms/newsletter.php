<?php
require_once __DIR__ . '/../app.php';

header('Content-Type: text/plain; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Invalid request method.';
    exit;
}

$email = trim($_POST['email'] ?? '');
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo 'Please enter a valid email address.';
    exit;
}

$subscribersFile = app_path('data/newsletter_subscribers.json');
$subscribers = app_read_json($subscribersFile, []);
if (!is_array($subscribers)) {
    $subscribers = [];
}

$exists = false;
foreach ($subscribers as $subscriber) {
    if (strcasecmp($subscriber['email'] ?? '', $email) === 0) {
        $exists = true;
        break;
    }
}

if (!$exists) {
    $subscribers[] = [
        'email' => $email,
        'created_at' => date(DATE_ATOM),
    ];
    app_write_json($subscribersFile, $subscribers);
}

echo 'OK';
