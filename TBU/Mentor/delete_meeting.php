<?php
require_once __DIR__ . '/app.php';
session_start();

header('Content-Type: text/plain; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'method_not_allowed';
    exit;
}

$payload = json_decode((string) file_get_contents('php://input'), true);
$id = $payload['id'] ?? '';

if (!is_string($id) || !preg_match('/^[a-f0-9]{16}$/', $id)) {
    http_response_code(422);
    echo 'invalid_id';
    exit;
}

$meetingsFile = app_path('meetings.json');
$meetings = app_read_json($meetingsFile, []);
if (!is_array($meetings)) {
    $meetings = [];
}

$updatedMeetings = array_values(array_filter(
    $meetings,
    static fn(array $meeting): bool => ($meeting['id'] ?? '') !== $id
));

if (count($updatedMeetings) === count($meetings)) {
    http_response_code(404);
    echo 'not_found';
    exit;
}

app_write_json($meetingsFile, $updatedMeetings);
echo 'success';
