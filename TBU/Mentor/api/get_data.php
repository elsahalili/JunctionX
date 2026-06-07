<?php
require_once __DIR__ . '/../app.php';

header('Content-Type: application/json; charset=utf-8');

$allowedTypes = ['events', 'favorites', 'notifications', 'progress'];
$type = $_GET['type'] ?? '';

if (!in_array($type, $allowedTypes, true)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data type.']);
    exit;
}

$file = app_path("data/{$type}.json");
echo json_encode(app_read_json($file, []), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
?>
