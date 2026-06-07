<?php
require_once __DIR__ . '/../app.php';

header('Content-Type: text/plain; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Invalid request method.';
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $subject === '' || $message === '') {
    http_response_code(422);
    echo 'Please fill in all fields with a valid email address.';
    exit;
}

$messagesFile = app_path('data/contact_messages.json');
$messages = app_read_json($messagesFile, []);
if (!is_array($messages)) {
    $messages = [];
}

$messages[] = [
    'name' => $name,
    'email' => $email,
    'subject' => $subject,
    'message' => $message,
    'created_at' => date(DATE_ATOM),
];

app_write_json($messagesFile, $messages);
echo 'OK';
