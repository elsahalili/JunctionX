<?php
require_once __DIR__ . '/../app.php';

header('Content-Type: application/json; charset=utf-8');

$allowedTypes = ['events', 'favorites', 'notifications', 'progress'];
$type = $_POST['type'] ?? '';
$data = $_POST['data'] ?? '';

if (!in_array($type, $allowedTypes, true)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data type.']);
    exit;
}

$decoded = json_decode((string) $data, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(422);
    echo json_encode(['error' => 'Invalid JSON payload.']);
    exit;
}

$file = app_path("data/{$type}.json");
app_write_json($file, $decoded);
echo json_encode(["status" => "success"]);
?>
